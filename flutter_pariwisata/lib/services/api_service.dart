import 'dart:convert';
import 'dart:io';
import 'dart:async'; // Untuk fungsi TimeoutException
import 'package:flutter/foundation.dart'; // Untuk mengecek kIsWeb
import 'package:http/http.dart' as http;
import 'package:geolocator/geolocator.dart';

class ApiService {
  // Jika berjalan di Chrome (Web), gunakan localhost. Jika di Android Emulator, gunakan 10.0.2.2 (alias ke 127.0.0.1 host)
  // Laravel berjalan di XAMPP Apache (port 80), bukan artisan serve (port 8000)
  static const String baseUrl = kIsWeb
      ? 'http://localhost/balente/backend-pariwisata/public/api'
      : 'http://10.0.2.2/balente/backend-pariwisata/public/api'; 
  static const Duration timeoutDuration = Duration(seconds: 15); // Batas maksimal respons 15 detik

  static Future<Position?> getCurrentLocation() async {
    bool serviceEnabled = await Geolocator.isLocationServiceEnabled();
    if (!serviceEnabled) return null;

    LocationPermission permission = await Geolocator.checkPermission();
    if (permission == LocationPermission.denied) {
      permission = await Geolocator.requestPermission();
      if (permission == LocationPermission.denied) return null;
    }
    
    if (permission == LocationPermission.deniedForever) return null;

    return await Geolocator.getCurrentPosition(desiredAccuracy: LocationAccuracy.high);
  }

  static Future<List<dynamic>> getRekomendasi(int userId, double lat, double lng, int maxRadius) async {
    try {
      final response = await http.get(
        Uri.parse('$baseUrl/rekomendasi?user_id=$userId&user_lat=$lat&user_long=$lng&max_radius=$maxRadius'),
      ).timeout(timeoutDuration);
      
      if (response.statusCode == 200) {
        final data = json.decode(response.body);
        return data['data'] ?? [];
      }
      throw Exception('Gagal mengambil data rekomendasi.');
    } on TimeoutException {
      throw Exception('Server terlalu lama merespons. Periksa koneksi internet Anda.');
    } on SocketException {
      throw Exception('Tidak bisa terhubung ke server Backend.');
    }
  }

  static Future<void> logInteraksi(int userId, String jenisInteraksi, {int? kategoriId}) async {
    try {
      await http.post(
        Uri.parse('$baseUrl/interaksi/log'),
        headers: {'Content-Type': 'application/json'},
        body: json.encode({
          'user_id': userId,
          'jenis_interaksi': jenisInteraksi,
          if (kategoriId != null) 'kategori_id': kategoriId
        }),
      ).timeout(const Duration(seconds: 5)); // Log timeout lebih cepat
    } catch (_) {
      // Background log, abaikan error secara silent jika gagal
    }
  }

  static Future<Map<String, dynamic>> sendChat(String message) async {
    try {
      final response = await http.post(
        Uri.parse('$baseUrl/ai/chat'),
        headers: {'Content-Type': 'application/json'},
        body: json.encode({'message': message}),
      ).timeout(timeoutDuration);
      
      if (response.statusCode == 200) {
        return json.decode(response.body);
      }
      throw Exception('Gagal menghubungi layanan AI');
    } on TimeoutException {
      throw Exception('Maaf, koneksi ke otak AI sedang timeout/terputus. Coba lagi ya.');
    } on SocketException {
      throw Exception('Server AI sedang mati / offline.');
    }
  }

  static Future<Map<String, dynamic>> scanImage(File imageFile) async {
    try {
      var request = http.MultipartRequest('POST', Uri.parse('$baseUrl/ai/scan'));
      request.files.add(await http.MultipartFile.fromPath('image', imageFile.path));
      
      var streamedResponse = await request.send().timeout(timeoutDuration);
      var response = await http.Response.fromStream(streamedResponse);
      
      if (response.statusCode == 200) {
        return json.decode(response.body);
      }
      throw Exception('Gagal memproses visual gambar');
    } on TimeoutException {
      throw Exception('Maaf, pemrosesan gambar YOLO melebihi batas waktu (Timeout). Coba gambar dengan resolusi lebih kecil.');
    } catch (e) {
      throw Exception('Terjadi kesalahan tidak terduga saat scan: $e');
    }
  }
}
