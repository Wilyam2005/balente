import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'package:cached_network_image/cached_network_image.dart';
import '../providers/spk_provider.dart';

class DashboardScreen extends StatefulWidget {
  const DashboardScreen({Key? key}) : super(key: key);

  @override
  State<DashboardScreen> createState() => _DashboardScreenState();
}

class _DashboardScreenState extends State<DashboardScreen> with AutomaticKeepAliveClientMixin {
  static const primaryBrown = Color(0xFF3D2B03);
  static const accentGold = Color(0xFFC8930A);
  static const lightCream = Color(0xFFFDF3D0);

  final List<String> _kategoriList = ['Semua', 'Alam', 'Budaya', 'Kuliner', 'Bahari'];
  final List<int> _radiusOptions = [5, 10, 20, 50];

  @override
  bool get wantKeepAlive => true;

  @override
  void initState() {
    super.initState();
    WidgetsBinding.instance.addPostFrameCallback((_) {
      context.read<SpkProvider>().fetchRekomendasi();
    });
  }

  IconData _getKategoriIcon(String cat) {
    switch (cat) {
      case 'Alam': return Icons.landscape;
      case 'Budaya': return Icons.festival;
      case 'Kuliner': return Icons.restaurant;
      case 'Bahari': return Icons.sailing;
      default: return Icons.category;
    }
  }

  @override
  Widget build(BuildContext context) {
    super.build(context);
    return Scaffold(
      appBar: AppBar(
        title: const Row(
          children: [
            Icon(Icons.villa, color: Colors.white, size: 32),
            SizedBox(width: 8),
            Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text('Balente', style: TextStyle(fontSize: 22, fontWeight: FontWeight.w900, letterSpacing: 1)),
                Text('Rekomendasi Pariwisata Lombok', style: TextStyle(fontSize: 11, fontWeight: FontWeight.w400)),
              ],
            ),
          ],
        ),
        actions: [
          IconButton(icon: const Icon(Icons.search), onPressed: () {}),
          IconButton(icon: const Icon(Icons.notifications_outlined), onPressed: () {}),
          Padding(
            padding: const EdgeInsets.symmetric(horizontal: 8.0),
            child: Consumer<SpkProvider>(
              builder: (context, provider, child) {
                return Container(
                  padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
                  decoration: BoxDecoration(
                    color: const Color(0xFF5C4200),
                    borderRadius: BorderRadius.circular(20),
                  ),
                  child: DropdownButton<int>(
                    value: provider.radius,
                    underline: const SizedBox(),
                    icon: const Icon(Icons.keyboard_arrow_down, color: Colors.white),
                    dropdownColor: const Color(0xFF5C4200),
                    style: const TextStyle(color: Colors.white, fontWeight: FontWeight.bold),
                    items: _radiusOptions.map((r) => DropdownMenuItem(
                      value: r,
                      child: Text('Radius: $r KM', style: const TextStyle(fontSize: 13)),
                    )).toList(),
                    onChanged: (val) {
                      if (val != null) provider.setRadius(val);
                    },
                  ),
                );
              }
            ),
          )
        ],
      ),
      body: Consumer<SpkProvider>(
        builder: (context, provider, child) {
          return CustomScrollView(
            physics: const BouncingScrollPhysics(),
            slivers: [
              // Hero Banner Keren
              SliverToBoxAdapter(
                child: _buildHeroBanner(),
              ),

              // Filter Kategori (Chips)
              SliverToBoxAdapter(
                child: SizedBox(
                  height: 70,
                  child: ListView.builder(
                    scrollDirection: Axis.horizontal,
                    physics: const BouncingScrollPhysics(),
                    padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 12),
                    itemCount: _kategoriList.length,
                    itemBuilder: (context, index) {
                      final cat = _kategoriList[index];
                      final isSelected = cat == provider.selectedKategori;
                      return Padding(
                        padding: const EdgeInsets.only(right: 12.0),
                        child: ChoiceChip(
                          avatar: Icon(_getKategoriIcon(cat), color: isSelected ? Colors.white : accentGold, size: 18),
                          label: Text(cat),
                          selected: isSelected,
                          onSelected: (_) => provider.setKategori(cat),
                          selectedColor: primaryBrown,
                          backgroundColor: Colors.white,
                          showCheckmark: false,
                          side: BorderSide(color: isSelected ? primaryBrown : Colors.brown.shade200),
                          labelStyle: TextStyle(
                            color: isSelected ? Colors.white : Colors.brown.shade600,
                            fontWeight: isSelected ? FontWeight.bold : FontWeight.normal
                          ),
                          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
                        ),
                      );
                    },
                  ),
                ),
              ),
              
              // Judul Section "Rekomendasi Terdekat"
              SliverToBoxAdapter(
                child: Padding(
                  padding: const EdgeInsets.fromLTRB(20, 10, 20, 16),
                  child: Row(
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: [
                      Row(
                        children: [
                          const Icon(Icons.near_me, color: primaryBrown, size: 20),
                          const SizedBox(width: 8),
                          const Text('Rekomendasi Terdekat', style: TextStyle(fontSize: 18, fontWeight: FontWeight.w900, color: primaryBrown)),
                        ],
                      ),
                      Container(
                        padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
                        decoration: BoxDecoration(color: lightCream, borderRadius: BorderRadius.circular(10)),
                        child: Text('${provider.rekomendasi.length} Tempat', style: const TextStyle(color: accentGold, fontWeight: FontWeight.bold, fontSize: 12)),
                      ),
                    ],
                  ),
                ),
              ),

              // Daftar Rekomendasi Destinasi
              if (provider.isLoading)
                const SliverFillRemaining(child: Center(child: CircularProgressIndicator(color: primaryBrown)))
              else if (provider.errorMessage != null)
                SliverFillRemaining(hasScrollBody: false, child: _buildErrorState(provider.errorMessage!))
              else if (provider.rekomendasi.isEmpty)
                SliverFillRemaining(hasScrollBody: false, child: _buildEmptyState())
              else
                SliverList(
                  delegate: SliverChildBuilderDelegate(
                    (context, index) {
                      final item = provider.rekomendasi[index];
                      return Padding(
                        padding: const EdgeInsets.symmetric(horizontal: 16),
                        child: _buildDestinasiCard(item),
                      );
                    },
                    childCount: provider.rekomendasi.length,
                  ),
                )
            ],
          );
        }
      ),
    );
  }

  // Desain Hero Banner
  Widget _buildHeroBanner() {
    return Container(
      width: double.infinity,
      margin: const EdgeInsets.fromLTRB(16, 20, 16, 8),
      padding: const EdgeInsets.all(24),
        decoration: BoxDecoration(
        borderRadius: BorderRadius.circular(24),
        gradient: const LinearGradient(
          colors: [Color(0xFF3D2B03), Color(0xFFC8930A)],
          begin: Alignment.topLeft,
          end: Alignment.bottomRight,
        ),
        boxShadow: [
          BoxShadow(color: const Color(0xFF3D2B03).withOpacity(0.3), blurRadius: 15, offset: const Offset(0, 10))
        ]
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          const Text(
            'Temukan Surga\nTersembunyi',
            style: TextStyle(fontSize: 28, fontWeight: FontWeight.w900, color: Colors.white, height: 1.2),
          ),
          const SizedBox(height: 12),
          Container(
            padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 6),
            decoration: BoxDecoration(
              color: Colors.white.withOpacity(0.2),
              borderRadius: BorderRadius.circular(8),
              border: Border.all(color: Colors.white.withOpacity(0.5))
            ),
            child: const Row(
              mainAxisSize: MainAxisSize.min,
              children: [
                Icon(Icons.location_on, color: Colors.white, size: 14),
                SizedBox(width: 4),
                Text('Lombok Timur, NTB', style: TextStyle(color: Colors.white, fontWeight: FontWeight.bold, fontSize: 12)),
              ],
            ),
          )
        ],
      ),
    );
  }

  // Desain Card Destinasi
  Widget _buildDestinasiCard(dynamic item) {
    return Card(
      margin: const EdgeInsets.only(bottom: 20),
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(20)),
      elevation: 3,
      shadowColor: Colors.black.withOpacity(0.1),
      clipBehavior: Clip.antiAlias,
      child: InkWell(
        onTap: () {},
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Stack(
              children: [
                CachedNetworkImage(
                  imageUrl: item['foto'] ?? '',
                  height: 180,
                  width: double.infinity,
                  fit: BoxFit.cover,
                  placeholder: (context, url) => const SizedBox(
                    height: 180, 
                    child: Center(child: CircularProgressIndicator(color: primaryBrown))
                  ),
                  errorWidget: (context, url, error) => Container(
                    height: 180,
                    color: Colors.grey.shade200,
                    child: Column(
                      mainAxisAlignment: MainAxisAlignment.center,
                      children: [
                        const Icon(Icons.broken_image, size: 50, color: Colors.grey),
                        Text('Gambar tidak tersedia', style: TextStyle(color: Colors.grey.shade600, fontSize: 12))
                      ],
                    ),
                  ),
                ),
                Positioned(
                  top: 12,
                  right: 12,
                  child: Container(
                    padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 6),
                    decoration: BoxDecoration(
                      color: Colors.white.withOpacity(0.9),
                      borderRadius: BorderRadius.circular(20),
                      boxShadow: [BoxShadow(color: Colors.black.withOpacity(0.1), blurRadius: 4)]
                    ),
                    child: Row(
                      children: [
                        const Icon(Icons.star, color: Colors.amber, size: 16),
                        const SizedBox(width: 4),
                        Text('Skor SPK: ${item['skor_saw'] ?? '0.0'}', style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 12)),
                      ],
                    ),
                  ),
                )
              ],
            ),
            Padding(
              padding: const EdgeInsets.all(16),
              child: Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  Expanded(
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(item['nama_tempat'] ?? 'Unknown', style: const TextStyle(fontSize: 18, fontWeight: FontWeight.bold, color: Colors.black87)),
                        const SizedBox(height: 6),
                        Container(
                          padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
                          decoration: BoxDecoration(color: lightCream, borderRadius: BorderRadius.circular(6)),
                          child: Text(item['kategori_nama'] ?? 'Umum', style: const TextStyle(fontSize: 12, fontWeight: FontWeight.bold, color: primaryBrown)),
                        )
                      ],
                    ),
                  ),
                  Column(
                    crossAxisAlignment: CrossAxisAlignment.end,
                    children: [
                      Row(
                        children: [
                          const Icon(Icons.location_on, size: 16, color: accentGold),
                          const SizedBox(width: 4),
                          Text('${item['jarak_km'] ?? '0'} km', style: const TextStyle(fontWeight: FontWeight.w900, fontSize: 16, color: primaryBrown)),
                        ],
                      ),
                      const SizedBox(height: 4),
                      Text('Dari lokasimu', style: TextStyle(fontSize: 11, color: Colors.grey.shade500, fontWeight: FontWeight.w500)),
                    ],
                  )
                ],
              ),
            )
          ],
        ),
      ),
    );
  }

  // Tampilan Empty State Menarik
  Widget _buildEmptyState() {
    return Container(
      padding: const EdgeInsets.all(32),
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Container(
            padding: const EdgeInsets.all(24),
            decoration: const BoxDecoration(color: lightCream, shape: BoxShape.circle),
            child: const Icon(Icons.travel_explore, size: 80, color: accentGold),
          ),
          const SizedBox(height: 24),
          const Text('Radius Terlalu Sempit!', style: TextStyle(fontSize: 20, fontWeight: FontWeight.w900, color: primaryBrown)),
          const SizedBox(height: 8),
          const Text(
            'Tidak ada destinasi yang ditemukan. Coba perbesar radius atau ganti kategori!', 
            textAlign: TextAlign.center, 
            style: TextStyle(color: Colors.grey, height: 1.5)
          ),
        ],
      ),
    );
  }

  // Tampilan Error State -> Data Belum Ditemukan
  Widget _buildErrorState(String errorMessage) {
    return Container(
      padding: const EdgeInsets.all(32),
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Container(
            padding: const EdgeInsets.all(24),
            decoration: const BoxDecoration(color: lightCream, shape: BoxShape.circle),
            child: const Icon(Icons.explore_off, size: 80, color: accentGold),
          ),
          const SizedBox(height: 24),
          const Text('Data Belum Ditemukan', style: TextStyle(fontSize: 20, fontWeight: FontWeight.w900, color: primaryBrown)),
          const SizedBox(height: 8),
          const Text(
            'Saat ini belum ada data destinasi atau koneksi ke server terputus.', 
            textAlign: TextAlign.center, 
            style: TextStyle(color: Colors.grey, height: 1.5)
          ),
          const SizedBox(height: 24),
          ElevatedButton.icon(
            onPressed: () => context.read<SpkProvider>().fetchRekomendasi(),
            icon: const Icon(Icons.refresh),
            label: const Text('Muat Ulang'),
            style: ElevatedButton.styleFrom(backgroundColor: primaryBrown),
          )
        ],
      ),
    );
  }
}
