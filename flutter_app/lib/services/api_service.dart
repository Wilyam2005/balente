import 'package:http/http.dart' as http;
import 'dart:convert';
import '../models/destination.dart';

class ApiService {
  static const baseUrl = 'http://127.0.0.1:8000/api';

  /// Simulasi pengambilan data destinasi dari backend Laravel
  static Future<List<Destination>> fetchDestinations() async {
    try {
      final url = Uri.parse('$baseUrl/destinasi');
      final response = await http.get(url).timeout(const Duration(seconds: 8));

      if (response.statusCode == 200) {
        final jsonResponse = json.decode(response.body);
        final data = jsonResponse['data'] as List<dynamic>;
        return data.map((item) {
          return Destination(
            id: item['id'].toString(),
            category: item['kategori']['nama_kategori'] ?? 'Alam',
            name: item['nama_tempat'] ?? 'Destinasi',
            imageUrl: item['image_url'] ?? 'https://picsum.photos/400/250',
            latitude: double.parse(item['latitude'].toString()),
            longitude: double.parse(item['longitude'].toString()),
            rating: 4.8,
            description: item['deskripsi'] ?? '',
            distanceKm: 0.0,
          );
        }).toList();
      }
    } catch (_) {
      // jika backend tidak tersedia, fallback data hardcoded
    }

    return [
      Destination(
        id: '1',
        category: 'Alam',
        name: 'Pantai Tangsi (Pink Beach)',
        imageUrl: 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e',
        latitude: -8.8604,
        longitude: 116.5242,
        rating: 4.9,
        description: 'Pantai dengan pasir berwarna merah muda yang unik di Lombok Timur.',
        distanceKm: 3.2,
      ),
      Destination(
        id: '2',
        category: 'Kuliner',
        name: 'Ayam Taliwang Desa',
        imageUrl: 'https://images.unsplash.com/photo-1543353071-087092ec393a',
        latitude: -8.8471,
        longitude: 116.4989,
        rating: 4.7,
        description: 'Nikmati ayam pedas khas Lombok Timur dengan cita rasa autentik.',
        distanceKm: 2.4,
      ),
    ];
  }
}
