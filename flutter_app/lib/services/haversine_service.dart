import 'dart:math';

class HaversineService {
  /// Hitung jarak antara dua koordinat dalam kilometer
  static double distanceBetween(double lat1, double lon1, double lat2, double lon2) {
    const earthRadius = 6371.0;
    final dLat = _degreeToRadian(lat2 - lat1);
    final dLon = _degreeToRadian(lon2 - lon1);

    final a = pow(sin(dLat / 2), 2) +
        cos(_degreeToRadian(lat1)) *
        cos(_degreeToRadian(lat2)) *
        pow(sin(dLon / 2), 2);

    final c = 2 * atan2(sqrt(a), sqrt(1 - a));
    return double.parse((earthRadius * c).toStringAsFixed(1));
  }

  static double _degreeToRadian(double degree) => degree * pi / 180;
}
