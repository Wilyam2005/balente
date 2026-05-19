import 'package:flutter/material.dart';

class FavoriteScreen extends StatelessWidget {
  const FavoriteScreen({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Destinasi Favorit', style: TextStyle(fontWeight: FontWeight.bold)),
      ),
      body: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Icon(Icons.favorite_border, size: 80, color: Colors.grey.shade400),
            const SizedBox(height: 16),
            const Text(
              'Belum Ada Favorit',
              style: TextStyle(fontSize: 20, fontWeight: FontWeight.bold, color: Colors.black87),
            ),
            const SizedBox(height: 8),
            Text(
              'Tandai destinasi pariwisata kesukaanmu\nagar mudah ditemukan nanti.',
              textAlign: TextAlign.center,
              style: TextStyle(color: Colors.grey.shade600),
            ),
            const SizedBox(height: 24),
            ElevatedButton.icon(
              onPressed: () {
                // Navigate back to Dashboard (Jelajah) tab
                // In a real app we would use state management to change the tab index
                ScaffoldMessenger.of(context).showSnackBar(
                  const SnackBar(content: Text('Silakan cari destinasi di tab Jelajah!'))
                );
              },
              icon: const Icon(Icons.explore),
              label: const Text('Mulai Jelajah'),
              style: ElevatedButton.styleFrom(
                backgroundColor: Colors.teal,
                foregroundColor: Colors.white,
                shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(20))
              ),
            )
          ],
        ),
      ),
    );
  }
}
