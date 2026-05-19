import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'providers/spk_provider.dart';
import 'screens/main_screen.dart';

// === BALENTE COLOR PALETTE (dari Logo) ===
// Primary: Cokelat Tua #3D2B03
// Accent/Gold: Kuning Emas #C8930A
// Light: Krem #FDF3D0
// ===========================================

void main() {
  runApp(
    MultiProvider(
      providers: [
        ChangeNotifierProvider(create: (_) => SpkProvider()),
      ],
      child: const MyApp(),
    ),
  );
}

class MyApp extends StatelessWidget {
  const MyApp({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    const primaryBrown = Color(0xFF3D2B03);
    const accentGold = Color(0xFFC8930A);
    const lightCream = Color(0xFFFDF3D0);

    return MaterialApp(
      title: 'Balente - Pariwisata Lombok Timur',
      debugShowCheckedModeBanner: false,
      theme: ThemeData(
        useMaterial3: true,
        primaryColor: primaryBrown,
        colorScheme: ColorScheme.fromSeed(
          seedColor: primaryBrown,
          primary: primaryBrown,
          secondary: accentGold,
          surface: Colors.white,
          background: const Color(0xFFF9F5ED),
        ),
        scaffoldBackgroundColor: const Color(0xFFF9F5ED),
        appBarTheme: const AppBarTheme(
          backgroundColor: primaryBrown,
          foregroundColor: Colors.white,
          elevation: 0,
          centerTitle: false,
          iconTheme: IconThemeData(color: Colors.white),
        ),
        cardTheme: CardThemeData(
          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(16)),
          elevation: 3,
          shadowColor: Color(0x333D2B03),
          color: Colors.white,
        ),
        elevatedButtonTheme: ElevatedButtonThemeData(
          style: ElevatedButton.styleFrom(
            backgroundColor: primaryBrown,
            foregroundColor: Colors.white,
            shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
            padding: const EdgeInsets.symmetric(horizontal: 24, vertical: 14),
            elevation: 2,
          )
        ),
        floatingActionButtonTheme: const FloatingActionButtonThemeData(
          backgroundColor: primaryBrown,
          foregroundColor: Colors.white,
          elevation: 4,
          shape: RoundedRectangleBorder(borderRadius: BorderRadius.all(Radius.circular(16))),
        ),
        chipTheme: ChipThemeData(
          selectedColor: primaryBrown,
          backgroundColor: Colors.white,
          labelStyle: const TextStyle(fontWeight: FontWeight.bold),
          side: BorderSide(color: Colors.brown.shade200),
        ),
        bottomAppBarTheme: const BottomAppBarThemeData(
          color: Colors.white,
          elevation: 10,
          shape: CircularNotchedRectangle(),
        ),
      ),
      home: const MainScreen(),
    );
  }
}
