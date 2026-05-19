import 'package:flutter/material.dart';
import 'dashboard_screen.dart';
import 'scanner_screen.dart';
import 'profile_screen.dart';
import 'chatbot_screen.dart';
import 'favorite_screen.dart';

class MainScreen extends StatefulWidget {
  const MainScreen({Key? key}) : super(key: key);

  @override
  State<MainScreen> createState() => _MainScreenState();
}

class _MainScreenState extends State<MainScreen> {
  static const primaryBrown = Color(0xFF3D2B03);
  static const accentGold = Color(0xFFC8930A);

  int _currentIndex = 0;

  final List<Widget> _pages = [
    const DashboardScreen(),
    const ScannerScreen(),
    const FavoriteScreen(),
    const ProfileScreen(),
  ];

  void _onTabTapped(int index) {
    setState(() => _currentIndex = index);
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: IndexedStack(
        index: _currentIndex,
        children: _pages,
      ),
      floatingActionButtonLocation: FloatingActionButtonLocation.centerDocked,
      floatingActionButton: Container(
        height: 64,
        width: 64,
        margin: const EdgeInsets.only(top: 30),
        child: FloatingActionButton(
          onPressed: () => Navigator.push(context, MaterialPageRoute(builder: (_) => const ChatbotScreen())),
          elevation: 6,
          backgroundColor: primaryBrown,
          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(20)),
          child: const Icon(Icons.smart_toy, size: 32, color: Colors.white),
        ),
      ),
      bottomNavigationBar: BottomAppBar(
        notchMargin: 8.0,
        child: SizedBox(
          height: 60,
          child: Row(
            mainAxisAlignment: MainAxisAlignment.spaceAround,
            children: [
              _buildTabItem(Icons.explore, 'Jelajah', 0),
              _buildTabItem(Icons.document_scanner, 'Scan', 1),
              const SizedBox(width: 40), // Ruang kosong untuk FAB di tengah
              _buildTabItem(Icons.favorite, 'Favorit', 2),
              _buildTabItem(Icons.person, 'Profil', 3),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildTabItem(IconData icon, String label, int index) {
    final isActive = _currentIndex == index;
    final color = isActive ? primaryBrown : Colors.grey;
    return InkWell(
      onTap: () => _onTabTapped(index),
      splashColor: Colors.transparent,
      highlightColor: Colors.transparent,
      child: Column(
        mainAxisSize: MainAxisSize.min,
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Icon(icon, color: color, size: 28),
          Text(label, style: TextStyle(color: color, fontSize: 10, fontWeight: FontWeight.bold))
        ],
      ),
    );
  }
}
