import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import '../providers/app_provider.dart';
import '../widgets/category_chip_bar.dart';
import '../widgets/destination_carousel.dart';
import '../widgets/radius_filter.dart';

class DashboardScreen extends StatelessWidget {
  const DashboardScreen({super.key});

  @override
  Widget build(BuildContext context) {
    final provider = context.watch<AppProvider>();

    return SafeArea(
      child: Padding(
        padding: const EdgeInsets.symmetric(horizontal: 16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const SizedBox(height: 16),
            _buildHeader(provider),
            const SizedBox(height: 20),
            _buildSearchBar(),
            const SizedBox(height: 16),
            RadiusFilter(
              selectedLabel: provider.selectedRadiusLabel,
              onChanged: (value, label) => provider.setRadius(value, label),
            ),
            const SizedBox(height: 16),
            CategoryChipBar(
              categories: provider.categories,
              selectedCategory: provider.selectedCategory,
              onSelected: provider.setCategory,
            ),
            const SizedBox(height: 20),
            Expanded(
              child: DestinationCarousel(
                destinations: provider.destinations
                    .where((dest) => provider.selectedCategory == 'Semua' || dest.category == provider.selectedCategory)
                    .where((dest) => dest.distanceKm <= provider.selectedRadiusKm)
                    .toList(),
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildHeader(AppProvider provider) {
    return Row(
      mainAxisAlignment: MainAxisAlignment.spaceBetween,
      children: [
        Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text(
              'Halo, ${provider.greetingName}!',
              style: const TextStyle(fontSize: 26, fontWeight: FontWeight.bold),
            ),
            const SizedBox(height: 4),
            Text(
              'Eksplorasi Lombok Timur',
              style: TextStyle(fontSize: 14, color: Colors.grey.shade700),
            ),
          ],
        ),
        Row(
          children: [
            IconButton(
              onPressed: () {},
              icon: const Icon(Icons.notifications_none),
              color: Colors.teal.shade700,
            ),
            const CircleAvatar(
              backgroundColor: Colors.teal,
              child: Icon(Icons.person, color: Colors.white),
            ),
          ],
        ),
      ],
    );
  }

  Widget _buildSearchBar() {
    return TextField(
      decoration: InputDecoration(
        hintText: 'Cari destinasi atau kuliner...',
        prefixIcon: const Icon(Icons.search),
        filled: true,
        fillColor: Colors.white,
        contentPadding: const EdgeInsets.symmetric(vertical: 0, horizontal: 16),
        border: OutlineInputBorder(
          borderRadius: BorderRadius.circular(16),
          borderSide: BorderSide.none,
        ),
      ),
    );
  }
}
