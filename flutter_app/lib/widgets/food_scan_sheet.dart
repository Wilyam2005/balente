import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import '../models/food_scan_result.dart';
import '../providers/app_provider.dart';

class FoodScanSheet extends StatelessWidget {
  final FoodScanResult scanResult;

  const FoodScanSheet({super.key, required this.scanResult});

  @override
  Widget build(BuildContext context) {
    return Positioned(
      bottom: 0,
      left: 0,
      right: 0,
      child: Container(
        decoration: const BoxDecoration(
          color: Colors.white,
          borderRadius: BorderRadius.vertical(top: Radius.circular(28)),
          boxShadow: [BoxShadow(color: Colors.black26, blurRadius: 20)],
        ),
        padding: const EdgeInsets.all(20),
        child: Column(
          mainAxisSize: MainAxisSize.min,
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Row(
              children: [
                const Text(
                  'Hasil Pemindaian',
                  style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
                ),
                const Spacer(),
                IconButton(
                  icon: const Icon(Icons.close),
                  onPressed: () => context.read<AppProvider>().clearScanResult(),
                ),
              ],
            ),
            const SizedBox(height: 8),
            Text('Makanan: ${scanResult.foodName}', style: const TextStyle(fontSize: 16, fontWeight: FontWeight.w600)),
            const SizedBox(height: 4),
            Text('Akurasi: ${(scanResult.confidence * 100).toStringAsFixed(0)}%', style: const TextStyle(color: Colors.grey)),
            const SizedBox(height: 12),
            Text(scanResult.description, style: const TextStyle(fontSize: 14, height: 1.5)),
            const SizedBox(height: 16),
            const Text('Restoran Terdekat', style: TextStyle(fontSize: 16, fontWeight: FontWeight.w600)),
            const SizedBox(height: 12),
            ...scanResult.nearbyRestaurants.map((restaurant) => Padding(
                  padding: const EdgeInsets.only(bottom: 12),
                  child: Row(
                    children: [
                      const Icon(Icons.restaurant, color: Colors.teal),
                      const SizedBox(width: 12),
                      Expanded(
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            Text(restaurant.name, style: const TextStyle(fontWeight: FontWeight.bold)),
                            const SizedBox(height: 2),
                            Text('${restaurant.distanceKm.toStringAsFixed(1)} km • ${restaurant.address}', style: const TextStyle(color: Colors.grey, fontSize: 13)),
                          ],
                        ),
                      ),
                      ElevatedButton(
                        onPressed: () {},
                        style: ElevatedButton.styleFrom(backgroundColor: Colors.teal.shade700),
                        child: const Text('Navigasi'),
                      ),
                    ],
                  ),
                )),
            const SizedBox(height: 20),
          ],
        ),
      ),
    );
  }
}
