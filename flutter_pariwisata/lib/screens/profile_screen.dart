import 'dart:io';
import 'package:flutter/foundation.dart';
import 'package:flutter/material.dart';
import 'package:image_picker/image_picker.dart';
import 'favorite_screen.dart';

class ProfileScreen extends StatefulWidget {
  const ProfileScreen({Key? key}) : super(key: key);

  @override
  State<ProfileScreen> createState() => _ProfileScreenState();
}

class _ProfileScreenState extends State<ProfileScreen> {
  static const primaryBrown = Color(0xFF3D2B03);
  static const accentGold = Color(0xFFC8930A);

  XFile? _profileImage;
  final ImagePicker _picker = ImagePicker();

  Future<void> _pickImage() async {
    showModalBottomSheet(
      context: context,
      shape: const RoundedRectangleBorder(borderRadius: BorderRadius.vertical(top: Radius.circular(20))),
      builder: (context) => SafeArea(
        child: Padding(
          padding: const EdgeInsets.all(16.0),
          child: Column(
            mainAxisSize: MainAxisSize.min,
            children: [
              Container(width: 40, height: 4, decoration: BoxDecoration(color: Colors.grey.shade300, borderRadius: BorderRadius.circular(4))),
              const SizedBox(height: 16),
              const Text('Ganti Foto Profil', style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold)),
              const SizedBox(height: 20),
              if (!kIsWeb) ...[
                ListTile(
                  leading: Container(padding: const EdgeInsets.all(8), decoration: BoxDecoration(color: const Color(0xFFFDF3D0), borderRadius: BorderRadius.circular(8)), child: const Icon(Icons.camera_alt, color: primaryBrown)),
                  title: const Text('Ambil Foto dari Kamera', style: TextStyle(fontWeight: FontWeight.bold)),
                  onTap: () async {
                    Navigator.pop(context);
                    final XFile? img = await _picker.pickImage(source: ImageSource.camera, imageQuality: 70);
                    if (img != null) setState(() => _profileImage = img);
                  },
                ),
              ],
              ListTile(
                leading: Container(padding: const EdgeInsets.all(8), decoration: BoxDecoration(color: const Color(0xFFFDF3D0), borderRadius: BorderRadius.circular(8)), child: const Icon(Icons.photo_library, color: primaryBrown)),
                title: const Text('Pilih dari Galeri', style: TextStyle(fontWeight: FontWeight.bold)),
                onTap: () async {
                  Navigator.pop(context);
                  final XFile? img = await _picker.pickImage(source: ImageSource.gallery, imageQuality: 70);
                  if (img != null) setState(() => _profileImage = img);
                },
              ),
              if (_profileImage != null)
                ListTile(
                  leading: Container(padding: const EdgeInsets.all(8), decoration: BoxDecoration(color: Colors.red.shade50, borderRadius: BorderRadius.circular(8)), child: const Icon(Icons.delete, color: Colors.red)),
                  title: const Text('Hapus Foto', style: TextStyle(fontWeight: FontWeight.bold, color: Colors.red)),
                  onTap: () {
                    Navigator.pop(context);
                    setState(() => _profileImage = null);
                  },
                ),
            ],
          ),
        ),
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Profil Akun', style: TextStyle(fontWeight: FontWeight.bold)),
      ),
      body: SingleChildScrollView(
        padding: const EdgeInsets.all(20),
        child: Column(
          children: [
            const SizedBox(height: 20),
            Center(
              child: Stack(
                children: [
                  GestureDetector(
                    onTap: _pickImage,
                    child: Container(
                      width: 110,
                      height: 110,
                      decoration: BoxDecoration(
                        shape: BoxShape.circle,
                        border: Border.all(color: accentGold, width: 3),
                        color: const Color(0xFFFDF3D0),
                      ),
                      child: ClipOval(
                        child: _profileImage != null
                          ? (kIsWeb
                              ? Image.network(_profileImage!.path, fit: BoxFit.cover)
                              : Image.file(File(_profileImage!.path), fit: BoxFit.cover))
                          : Icon(Icons.person, size: 70, color: primaryBrown.withOpacity(0.5)),
                      ),
                    ),
                  ),
                  Positioned(
                    bottom: 2,
                    right: 2,
                    child: GestureDetector(
                      onTap: _pickImage,
                      child: Container(
                        padding: const EdgeInsets.all(6),
                        decoration: const BoxDecoration(color: primaryBrown, shape: BoxShape.circle),
                        child: const Icon(Icons.camera_alt, color: Colors.white, size: 16),
                      ),
                    ),
                  ),
                ],
              ),
            ),
            const SizedBox(height: 16),
            const Text('Wilyam', style: TextStyle(fontSize: 24, fontWeight: FontWeight.w900, color: primaryBrown)),
            const SizedBox(height: 4),
            Text('wilyam@mahasiswa.ac.id', style: TextStyle(color: Colors.brown.shade400)),
            const SizedBox(height: 8),
            Container(
              padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 4),
              decoration: BoxDecoration(color: const Color(0xFFFDF3D0), borderRadius: BorderRadius.circular(20)),
              child: const Text('Pengguna Aktif', style: TextStyle(color: accentGold, fontWeight: FontWeight.bold, fontSize: 12)),
            ),
            const SizedBox(height: 32),
            
            // Menu Akun
            _buildMenuTile(Icons.person_outline, 'Edit Profil', () => _showEditProfileModal(context)),
            _buildMenuTile(Icons.history, 'Riwayat Perjalanan (SPK)', () => _showRiwayatModal(context)),
            _buildMenuTile(Icons.favorite_border, 'Destinasi Favorit', () => Navigator.push(context, MaterialPageRoute(builder: (_) => const FavoriteScreen()))),
            const Divider(height: 40),
            _buildMenuTile(Icons.settings, 'Pengaturan Aplikasi', () => _showDialog(context, 'Pengaturan', 'Fitur pengaturan (Notifikasi & Tema) akan segera hadir.')),
            _buildMenuTile(Icons.help_outline, 'Bantuan & FAQ', () => _showDialog(context, 'Bantuan', 'Jika mengalami kendala, hubungi Administrator di admin@balente.id')),
            const SizedBox(height: 20),
            
            SizedBox(
              width: double.infinity,
              child: OutlinedButton.icon(
                onPressed: () => _showLogoutConfirm(context),
                icon: const Icon(Icons.logout, color: Colors.red),
                label: const Text('Keluar (Logout)', style: TextStyle(color: Colors.red, fontWeight: FontWeight.bold)),
                style: OutlinedButton.styleFrom(
                  padding: const EdgeInsets.symmetric(vertical: 14),
                  side: const BorderSide(color: Colors.red),
                  shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12))
                ),
              ),
            ),
            const SizedBox(height: 20),
          ],
        ),
      ),
    );
  }

  Widget _buildMenuTile(IconData icon, String title, VoidCallback onTap) {
    return ListTile(
      leading: Container(
        padding: const EdgeInsets.all(8),
        decoration: BoxDecoration(color: const Color(0xFFFDF3D0), borderRadius: BorderRadius.circular(8)),
        child: Icon(icon, color: const Color(0xFF3D2B03)),
      ),
      title: Text(title, style: const TextStyle(fontWeight: FontWeight.bold)),
      trailing: const Icon(Icons.chevron_right, color: Colors.grey),
      contentPadding: const EdgeInsets.symmetric(vertical: 4),
      onTap: onTap,
    );
  }

  void _showDialog(BuildContext context, String title, String msg) {
    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        title: Text(title, style: const TextStyle(fontWeight: FontWeight.bold, color: primaryBrown)),
        content: Text(msg),
        actions: [TextButton(onPressed: () => Navigator.pop(context), child: const Text('Mengerti', style: TextStyle(color: primaryBrown)))],
      )
    );
  }

  void _showLogoutConfirm(BuildContext context) {
    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        title: const Text('Keluar', style: TextStyle(fontWeight: FontWeight.bold, color: Colors.red)),
        content: const Text('Apakah Anda yakin ingin keluar dari akun ini?'),
        actions: [
          TextButton(onPressed: () => Navigator.pop(context), child: const Text('Batal', style: TextStyle(color: Colors.grey))),
          ElevatedButton(
            onPressed: () { Navigator.pop(context); ScaffoldMessenger.of(context).showSnackBar(const SnackBar(content: Text('Berhasil Logout.'))); },
            style: ElevatedButton.styleFrom(backgroundColor: Colors.red),
            child: const Text('Ya, Keluar')
          )
        ],
      )
    );
  }

  void _showEditProfileModal(BuildContext context) {
    showModalBottomSheet(
      context: context,
      isScrollControlled: true,
      shape: const RoundedRectangleBorder(borderRadius: BorderRadius.vertical(top: Radius.circular(24))),
      builder: (context) => Padding(
        padding: EdgeInsets.only(bottom: MediaQuery.of(context).viewInsets.bottom + 24, left: 24, right: 24, top: 24),
        child: Column(
          mainAxisSize: MainAxisSize.min,
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const Text('Edit Profil', style: TextStyle(fontSize: 20, fontWeight: FontWeight.bold, color: primaryBrown)),
            const SizedBox(height: 16),
            TextField(
              decoration: const InputDecoration(labelText: 'Nama Lengkap', border: OutlineInputBorder(), prefixIcon: Icon(Icons.person, color: primaryBrown)),
              controller: TextEditingController(text: 'Wilyam'),
            ),
            const SizedBox(height: 16),
            TextField(
              decoration: const InputDecoration(labelText: 'Email', border: OutlineInputBorder(), prefixIcon: Icon(Icons.email, color: primaryBrown)),
              controller: TextEditingController(text: 'wilyam@mahasiswa.ac.id'),
            ),
            const SizedBox(height: 24),
            SizedBox(
              width: double.infinity,
              child: ElevatedButton(
                onPressed: () {
                  Navigator.pop(context);
                  ScaffoldMessenger.of(context).showSnackBar(const SnackBar(content: Text('Profil berhasil disimpan!')));
                },
                style: ElevatedButton.styleFrom(backgroundColor: primaryBrown, padding: const EdgeInsets.all(16)),
                child: const Text('Simpan Perubahan'),
              ),
            ),
          ],
        ),
      )
    );
  }

  void _showRiwayatModal(BuildContext context) {
    showModalBottomSheet(
      context: context,
      isScrollControlled: true,
      shape: const RoundedRectangleBorder(borderRadius: BorderRadius.vertical(top: Radius.circular(24))),
      builder: (context) => DraggableScrollableSheet(
        initialChildSize: 0.6,
        minChildSize: 0.4,
        maxChildSize: 0.9,
        expand: false,
        builder: (_, controller) => Column(
          children: [
            Padding(
              padding: const EdgeInsets.all(16),
              child: Column(
                children: [
                  Container(width: 40, height: 4, decoration: BoxDecoration(color: Colors.grey.shade300, borderRadius: BorderRadius.circular(4))),
                  const SizedBox(height: 12),
                  const Text('Riwayat Perjalanan (SPK)', style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold, color: primaryBrown)),
                ],
              ),
            ),
            Expanded(
              child: ListView(
                controller: controller,
                padding: const EdgeInsets.symmetric(horizontal: 16),
                children: [
                  _buildRiwayatItem('Pantai Pink Tangsi', 'Bahari', '0.89', '15 Mei 2026'),
                  _buildRiwayatItem('Bukit Sembalun', 'Alam', '0.92', '10 Mei 2026'),
                  _buildRiwayatItem('Desa Sade', 'Budaya', '0.76', '02 Mei 2026'),
                ],
              ),
            ),
          ],
        ),
      )
    );
  }

  Widget _buildRiwayatItem(String nama, String kategori, String skor, String tanggal) {
    return Card(
      margin: const EdgeInsets.only(bottom: 12),
      child: ListTile(
        leading: Container(
          padding: const EdgeInsets.all(8),
          decoration: BoxDecoration(color: const Color(0xFFFDF3D0), borderRadius: BorderRadius.circular(8)),
          child: const Icon(Icons.place, color: primaryBrown),
        ),
        title: Text(nama, style: const TextStyle(fontWeight: FontWeight.bold)),
        subtitle: Text('$kategori • $tanggal', style: TextStyle(color: Colors.brown.shade400)),
        trailing: Container(
          padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
          decoration: BoxDecoration(color: const Color(0xFFFDF3D0), borderRadius: BorderRadius.circular(8)),
          child: Text('SPK: $skor', style: const TextStyle(color: accentGold, fontWeight: FontWeight.bold, fontSize: 12)),
        ),
      ),
    );
  }
}
