import 'package:flutter/material.dart';
import '../services/api_service.dart';

class SpkProvider with ChangeNotifier {
  List<dynamic> _rekomendasi = [];
  bool _isLoading = false;
  String? _errorMessage;
  int _radius = 10;
  String _selectedKategori = 'Semua';

  // Getter
  List<dynamic> get rekomendasi {
    if (_selectedKategori == 'Semua') return _rekomendasi;
    return _rekomendasi.where((item) => item['kategori_nama'] == _selectedKategori).toList();
  }
  
  bool get isLoading => _isLoading;
  String? get errorMessage => _errorMessage;
  int get radius => _radius;
  String get selectedKategori => _selectedKategori;

  // Setter & Actions
  void setRadius(int val) {
    _radius = val;
    fetchRekomendasi();
  }

  void setKategori(String val) {
    _selectedKategori = val;
    notifyListeners();
  }

  Future<void> fetchRekomendasi() async {
    _isLoading = true;
    _errorMessage = null; // Reset error saat mulai memanggil ulang
    notifyListeners();

    try {
      final loc = await ApiService.getCurrentLocation();
      double lat = loc?.latitude ?? -8.6521;
      double lng = loc?.longitude ?? 116.5350;

      _rekomendasi = await ApiService.getRekomendasi(1, lat, lng, _radius);
    } catch (e) {
      _rekomendasi = [];
      _errorMessage = e.toString().replaceAll('Exception: ', '');
    }

    _isLoading = false;
    notifyListeners();
  }
}
