import 'restaurant.dart';

class FoodScanResult {
  final String foodName;
  final double confidence;
  final String description;
  final List<Restaurant> nearbyRestaurants;

  FoodScanResult({
    required this.foodName,
    required this.confidence,
    required this.description,
    required this.nearbyRestaurants,
  });
}
