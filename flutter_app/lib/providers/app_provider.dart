import 'package:flutter/material.dart';
import '../models/chat_message.dart';
import '../models/destination.dart';
import '../models/food_scan_result.dart';
import '../models/restaurant.dart';
import '../services/api_service.dart';
import '../services/haversine_service.dart';
import '../services/location_service.dart';

class AppProvider extends ChangeNotifier {
  int selectedIndex = 0;
  String greetingName = 'Wilyam';
  String selectedCategory = 'Alam';
  String selectedRadiusLabel = '< 5 km';
  double selectedRadiusKm = 5.0;
  final List<String> categories = [
    'Alam',
    'Budaya/Adat',
    'Religi',
    'Kuliner',
    'Sejarah',
    'Bahari',
    'Edukasi',
    'Rekreasi',
    'Petualangan',
  ];
  List<Destination> destinations = [];
  List<ChatMessage> chatMessages = [];
  List<String> quickReplies = [
    'Kuliner terdekat?',
    'Pantai pasir putih?',
    'Rekomendasi alam?',
    'Wisata sejarah?',
  ];
  bool isLoadingDestinations = false;
  bool isScanningFood = false;
  FoodScanResult? scanResult;
  double userLat = -8.5833;
  double userLng = 116.3194;

  /// Inisialisasi data awal ketika aplikasi diluncurkan
  Future<void> initializeApp() async {
    await loadInitialLocation();
    await loadDestinations();
    chatMessages = [
      ChatMessage(
        text: 'Halo, saya asisten wisata Lombok Timur. Bagaimana saya bisa membantu?',
        isUser: false,
      ),
    ];
    notifyListeners();
  }

  /// Ubah tab utama aplikasi berdasarkan indeks
  void setIndex(int index) {
    selectedIndex = index;
    notifyListeners();
  }

  /// Pilih kategori destinasi untuk memfilter rekomendasi
  void setCategory(String category) {
    selectedCategory = category;
    notifyListeners();
  }

  /// Pilih radius pembatas jarak destinasi
  void setRadius(double km, String label) {
    selectedRadiusKm = km;
    selectedRadiusLabel = label;
    notifyListeners();
  }

  /// Memuat destinasi awal dari service, lalu hitung jarak menggunakan Haversine
  Future<void> loadDestinations() async {
    isLoadingDestinations = true;
    notifyListeners();

    final items = await ApiService.fetchDestinations();
    destinations = items.map((destination) {
      final distance = HaversineService.distanceBetween(
        userLat,
        userLng,
        destination.latitude,
        destination.longitude,
      );
      return destination.copyWith(distanceKm: distance);
    }).toList();

    isLoadingDestinations = false;
    notifyListeners();
  }

  /// Mendapatkan lokasi user dengan permission geolocator
  Future<void> loadInitialLocation() async {
    final position = await LocationService.getCurrentLocation();
    userLat = position.latitude;
    userLng = position.longitude;
    notifyListeners();
  }

  /// Mengirimkan pesan dari user dan memproses jawaban AI sederhana
  Future<void> sendMessage(String message) async {
    final userMessage = ChatMessage(text: message, isUser: true);
    chatMessages.add(userMessage);
    notifyListeners();

    await Future.delayed(const Duration(milliseconds: 800));
    final response = _generateAIBotResponse(message);
    chatMessages.add(response);
    notifyListeners();
  }

  /// Simulasi jawaban AI dengan rendering card destinasi jika cocok
  ChatMessage _generateAIBotResponse(String query) {
    if (query.toLowerCase().contains('kuliner')) {
      return ChatMessage(
        text: 'Saya menemukan beberapa kuliner lokal yang populer.',
        isUser: false,
        recommendedDestination: destinations.firstWhere(
          (item) => item.category == 'Kuliner',
          orElse: () => destinations.first,
        ),
      );
    }

    return ChatMessage(
      text: 'Berikut rekomendasi destinasi terbaik untukmu di Lombok Timur.',
      isUser: false,
      recommendedDestination: destinations.first,
    );
  }

  /// Simulasi pemindaian makanan dengan API YOLO palsu
  Future<void> scanFood() async {
    isScanningFood = true;
    notifyListeners();

    await Future.delayed(const Duration(seconds: 2));
    scanResult = FoodScanResult(
      foodName: 'Ayam Taliwang',
      confidence: 0.96,
      description: 'Ayam pedas khas Lombok dengan bumbu tradisional dan aroma wangi.',
      nearbyRestaurants: [
        Restaurant(
          name: 'Warung Taliwang Asli',
          distanceKm: 0.8,
          address: 'Jalan Raya Sembalun',
          latitude: userLat + 0.005,
          longitude: userLng + 0.003,
        ),
        Restaurant(
          name: 'Restoran Madu Lombok',
          distanceKm: 1.6,
          address: 'Sekitar Pantai Lombok',
          latitude: userLat + 0.01,
          longitude: userLng - 0.002,
        ),
        Restaurant(
          name: 'Dapur Santan Lombok',
          distanceKm: 2.3,
          address: 'Kota Selong',
          latitude: userLat - 0.004,
          longitude: userLng + 0.007,
        ),
      ],
    );

    isScanningFood = false;
    notifyListeners();
  }

  /// Membersihkan hasil scan agar UI dapat ditutup secara manual
  void clearScanResult() {
    scanResult = null;
    notifyListeners();
  }
}
