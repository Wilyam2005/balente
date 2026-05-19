import 'package:flutter/material.dart';
import 'package:flutter_markdown/flutter_markdown.dart';
import 'package:google_generative_ai/google_generative_ai.dart';
import '../services/api_service.dart';

class ChatbotScreen extends StatefulWidget {
  const ChatbotScreen({Key? key}) : super(key: key);

  @override
  State<ChatbotScreen> createState() => _ChatbotScreenState();
}

class ChatMessage {
  final String text;
  final bool isUser;
  final dynamic rekomendasiData;
  ChatMessage({required this.text, required this.isUser, this.rekomendasiData});
}

class _ChatbotScreenState extends State<ChatbotScreen> {
  final TextEditingController _controller = TextEditingController();
  final ScrollController _scrollController = ScrollController();
  final List<ChatMessage> _messages = [];
  bool _isTyping = false;

  @override
  void initState() {
    super.initState();
    _messages.add(ChatMessage(text: 'Tabe! Saya Asisten AI. Ada yang bisa dibantu?', isUser: false));
  }

  void _sendMessage(String text) async {
    if (text.trim().isEmpty) return;
    
    setState(() {
      _messages.add(ChatMessage(text: text, isUser: true));
      _isTyping = true;
    });
    _controller.clear();
    _scrollToBottom();
    
    // Log Interaksi AI NLP
    ApiService.logInteraksi(1, 'chat_nlp');

    // Simulate network delay
    await Future.delayed(const Duration(seconds: 1));
    
    String reply = "Tabe! Terima kasih atas pertanyaannya. Saat ini saya sedang dalam mode demonstrasi offline. Silakan pilih salah satu opsi rekomendasi di atas untuk melihat respon.";
    
    if (text.toLowerCase().contains('rinjani')) {
      reply = """### ⛰️ Rinjani & Sembalun\n\n**Deskripsi:**\nKawasan surga di ketinggian Lombok. Gunung Rinjani menawarkan jalur pendakian kelas dunia dengan panorama Danau Segara Anak yang memukau. Sementara itu, lereng Sembalun menyajikan hamparan perbukitan hijau, area agrowisata stroberi, dan udara sejuk pegunungan yang menenangkan jiwa.\n\n**Rekomendasi Spot:**\n* **Taman Nasional Gunung Rinjani (TNGR):** Puncak Rinjani, Danau Segara Anak, dan Pemandian Air Panas Aik Kalak.\n* **Kawasan Sembalun:** Bukit Selong, Pusuk Sembalun, Bukit Pergasingan, dan Kebun Stroberi.\n\n**Informasi Tiket & Estimasi Harga:**\n* **Tiket Pendakian Rinjani (WNI):** Sekitar Rp5.000/hari (hari kerja) - Rp7.500/hari (hari libur). *Catatan: Wajib menggunakan jasa guide/porter untuk pendakian resmi.*\n* **Paket Trekking Rinjani (Open Trip/Private):** Mulai dari Rp1.500.000 - Rp3.000.000+ (tergantung durasi dan layanan).\n* **Tiket Masuk Bukit Pergasingan/Selong:** Sekitar Rp15.000 - Rp25.000/orang.\n* **Parkir Kendaraan di Sembalun:** Rp5.000 (Motor) - Rp10.000 (Mobil).\n\n**Tips:** Siapkan kondisi fisik yang prima jika ingin mendaki, dan pastikan membawa jaket tebal karena suhu di Sembalun bisa sangat dingin terutama saat malam dan menjelang pagi.""";
    } else if (text.toLowerCase().contains('pantai')) {
      reply = """### 🏖️ Pantai Eksotis\n\n**Deskripsi:**\nGaris pantai Lombok tidak pernah gagal memikat hati. Kategori ini merangkum keindahan pesisir dari ujung ke ujung, mulai dari fenomena pasir merah muda yang langka, teluk berpasir putih bak merica, hingga gugusan pulau kecil (Gili) dengan taman bawah laut yang dihuni penyu.\n\n**Rekomendasi Spot:**\n* **Lombok Timur:** Pantai Pink (Tangsi), Tanjung Ringgit.\n* **Lombok Tengah (Mandalika):** Pantai Tanjung Aan, Pantai Kuta, Pantai Seger.\n* **Lombok Utara:** Tiga Gili (Trawangan, Meno, Air).\n\n**Informasi Tiket & Estimasi Harga:**\n* **Tiket Masuk Pantai (Umumnya):** Gratis, sebagian besar hanya dikenakan biaya parkir Rp5.000 - Rp10.000.\n* **Sewa Perahu ke Pantai Pink / Gili Nanggu (PP):** Sekitar Rp350.000 - Rp500.000/kapal (kapasitas hingga 10 orang).\n* **Sewa Alat Snorkeling:** Rp50.000/set.\n* **Sewa Kursi Jemur / Gazebo di Tanjung Aan:** Rp50.000 (atau gratis jika membeli makanan/minuman di warung penyewa).\n\n**Tips:** Waktu terbaik mengunjungi pantai di Lombok adalah pagi hari atau sore hari menjelang *sunset*. Jangan lupa bawa *sunblock* ramah lingkungan koral!""";
    } else if (text.toLowerCase().contains('kuliner')) {
      reply = """### 🌶️ Kuliner Pedas\n\n**Deskripsi:**\nEksplorasi mahakarya gastronomi lokal yang kaya rempah! Lombok ("Lombok" sendiri berarti cabai dalam bahasa setempat) terkenal dengan sajian kulinernya yang berani, gurih, dan siap membakar lidah. Pengalaman wisata belum lengkap tanpa mencicipi hidangan otentik ini.\n\n**Rekomendasi Menu & Lokasi:**\n* **Ayam Taliwang & Plecing Kangkung:** Daging ayam kampung bakar bumbu pedas manis, disajikan dengan kangkung segar bersambal tomat. (Rekomendasi: Lesehan Nada, Kampung Taliwang).\n* **Sate Rembiga:** Sate daging sapi empuk dengan bumbu marinasi pedas manis meresap. (Rekomendasi: Sate Rembiga Ibu Sinnaseh).\n* **Nasi Balap Puyung:** Nasi campur dengan suwiran ayam pedas, kedelai goreng, dan abon. (Rekomendasi: Nasi Balap Puyung Inaq Esun).\n* **Sate Bulayak:** Sate daging/jeroan sapi dengan bumbu khas dan lontong panjang (bulayak).\n\n**Estimasi Harga:**\n* **Ayam Taliwang (1 Ekor + Nasi):** Rp60.000 - Rp85.000.\n* **Sate Rembiga (10 Tusuk):** Rp25.000 - Rp35.000.\n* **Nasi Balap Puyung:** Rp15.000 - Rp25.000/porsi.\n* **Plecing Kangkung:** Rp10.000 - Rp15.000/porsi.\n\n**Tips:** Siapkan minuman dingin atau teh manis hangat untuk meredakan rasa pedas. Tingkat kepedasan (level) seringkali bisa *di-request* menyesuaikan selera.""";
    } else if (text.toLowerCase().contains('budaya') || text.toLowerCase().contains('tenun')) {
      reply = """### 🧶 Budaya Sasak\n\n**Deskripsi:**\nSelami denyut nadi kebudayaan asli Pulau Seribu Masjid. Nikmati arsitektur tradisional rumah *Bale Tani* yang unik, alunan musik *Gendang Beleq*, hingga melihat langsung kelihaian jemari para wanita Sasak dalam menenun benang menjadi selembar kain songket mahakarya yang bernilai tinggi.\n\n**Rekomendasi Spot:**\n* **Desa Wisata Sade & Ende:** Melihat langsung keseharian Suku Sasak dan arsitektur rumah lantai tanah liat.\n* **Desa Pringgasela & Sukarara:** Sentra pembuatan kain tenun tradisional dan songket khas Lombok.\n* **Desa Banyumulek:** Sentra kerajinan gerabah tanah liat berkualitas ekspor.\n\n**Informasi Tiket & Estimasi Harga:**\n* **Tiket Masuk Desa Sade/Ende:** Sistem donasi sukarela (biasanya mengisi buku tamu dan memasukkan uang ke kotak, rata-rata Rp10.000 - Rp20.000/orang). Jasa pemandu lokal (warga desa) juga dibayar seikhlasnya.\n* **Kain Tenun / Songket:** Mulai dari Rp150.000 (untuk syal/selendang kecil) hingga jutaan rupiah (untuk kain sarung/songket motif rumit dan bahan sutra).\n* **Kerajinan Gerabah:** Mulai dari Rp15.000 hingga ratusan ribu rupiah.\n\n**Tips:** Saat berkunjung ke sentra tenun, cobalah berfoto mengenakan pakaian adat Sasak (biasanya disediakan gratis atau dengan biaya sewa murah jika membeli kain). Selalu jaga etika dan hargai privasi penduduk lokal saat mengambil foto di desa wisata.""";
    }

    if (!mounted) return;
    setState(() {
      _isTyping = false;
      _messages.add(ChatMessage(
        text: reply, 
        isUser: false,
        rekomendasiData: null
      ));
    });
    _scrollToBottom();
  }

  void _scrollToBottom() {
    Future.delayed(const Duration(milliseconds: 100), () {
      if (_scrollController.hasClients) {
        _scrollController.animateTo(
          _scrollController.position.maxScrollExtent,
          duration: const Duration(milliseconds: 300),
          curve: Curves.easeOut,
        );
      }
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF5F9F9),
      appBar: AppBar(
        title: const Text('Asisten AI Cerdas'),
        backgroundColor: Colors.teal,
        elevation: 0,
      ),
      body: Column(
        children: [
          Expanded(
            child: ListView.builder(
              controller: _scrollController,
              padding: const EdgeInsets.all(16),
              itemCount: _messages.length,
              itemBuilder: (context, index) => _buildChatBubble(_messages[index]),
            ),
          ),
          if (_isTyping)
            Padding(
              padding: const EdgeInsets.only(left: 16.0, bottom: 8.0, top: 8.0),
              child: Row(
                crossAxisAlignment: CrossAxisAlignment.end,
                children: [
                  const CircleAvatar(
                    radius: 16,
                    backgroundColor: Colors.teal,
                    child: Icon(Icons.smart_toy, size: 20, color: Colors.white),
                  ),
                  const SizedBox(width: 8),
                  Container(
                    padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 16),
                    decoration: BoxDecoration(
                      color: Colors.white,
                      borderRadius: const BorderRadius.only(
                        topLeft: Radius.circular(20),
                        topRight: Radius.circular(20),
                        bottomRight: Radius.circular(20),
                      ),
                      border: Border.all(color: Colors.teal.shade100, width: 1),
                      boxShadow: [
                        BoxShadow(color: Colors.black.withOpacity(0.02), blurRadius: 5, offset: const Offset(0, 2))
                      ]
                    ),
                    child: const TypingIndicator(),
                  ),
                ],
              ),
            ),
          _buildQuickReplies(),
          Container(
            padding: const EdgeInsets.all(12),
            decoration: BoxDecoration(
              color: Colors.white,
              boxShadow: [
                BoxShadow(color: Colors.grey.withOpacity(0.1), blurRadius: 10, offset: const Offset(0, -3))
              ]
            ),
            child: Row(
              children: [
                Expanded(
                  child: TextField(
                    controller: _controller,
                    decoration: InputDecoration(
                      hintText: 'Tanya rekomendasi...',
                      border: OutlineInputBorder(borderRadius: BorderRadius.circular(24), borderSide: BorderSide.none),
                      filled: true,
                      fillColor: Colors.grey[100],
                      contentPadding: const EdgeInsets.symmetric(horizontal: 20, vertical: 10),
                    ),
                    onSubmitted: _sendMessage,
                  ),
                ),
                const SizedBox(width: 8),
                CircleAvatar(
                  backgroundColor: Colors.teal,
                  radius: 24,
                  child: IconButton(
                    icon: const Icon(Icons.send, color: Colors.white, size: 20),
                    onPressed: () => _sendMessage(_controller.text),
                  ),
                )
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildQuickReplies() {
    return SingleChildScrollView(
      scrollDirection: Axis.horizontal,
      padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
      child: Row(
        children: [
          _quickReplyChip('🏔️ Rinjani & Sembalun', 'Rekomendasi Rinjani via Sembalun'),
          const SizedBox(width: 8),
          _quickReplyChip('🏖️ Pantai Eksotis', 'Pantai Pink & Tanjung Ringgit'),
          const SizedBox(width: 8),
          _quickReplyChip('🌶️ Kuliner Pedas', 'Kuliner Ayam Rarang & Sate Rembiga'),
          const SizedBox(width: 8),
          _quickReplyChip('🧶 Budaya Sasak', 'Desa Tenun Pringgasela & Budaya'),
        ],
      ),
    );
  }

  Widget _quickReplyChip(String label, String actionText) {
    return ActionChip(
      label: Text(label, style: TextStyle(color: Colors.teal.shade900)),
      backgroundColor: Colors.teal.shade50,
      side: BorderSide(color: Colors.teal.shade200),
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(20)),
      onPressed: () => _sendMessage(actionText),
    );
  }

  Widget _buildChatBubble(ChatMessage message) {
    return AnimatedChatBubble(message: message);
  }
}

class AnimatedChatBubble extends StatelessWidget {
  final ChatMessage message;
  const AnimatedChatBubble({Key? key, required this.message}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    bool isUser = message.isUser;
    
    return TweenAnimationBuilder(
      tween: Tween<double>(begin: 0, end: 1),
      duration: const Duration(milliseconds: 400),
      curve: Curves.easeOutCubic,
      builder: (context, double val, child) {
        return Transform.translate(
          offset: Offset(0, 20 * (1 - val)),
          child: Opacity(
            opacity: val,
            child: child,
          ),
        );
      },
      child: Padding(
        padding: const EdgeInsets.only(bottom: 12),
        child: Row(
          mainAxisAlignment: isUser ? MainAxisAlignment.end : MainAxisAlignment.start,
          crossAxisAlignment: CrossAxisAlignment.end,
          children: [
            if (!isUser) ...[
              const CircleAvatar(
                radius: 16,
                backgroundColor: Colors.teal,
                child: Icon(Icons.smart_toy, size: 20, color: Colors.white),
              ),
              const SizedBox(width: 8),
            ],
            Flexible(
              child: Container(
                padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 12),
                constraints: BoxConstraints(maxWidth: MediaQuery.of(context).size.width * 0.75),
                decoration: BoxDecoration(
                  gradient: isUser ? LinearGradient(colors: [Colors.teal.shade400, Colors.teal.shade600]) : null,
                  color: isUser ? null : Colors.white,
                  borderRadius: BorderRadius.only(
                    topLeft: const Radius.circular(20),
                    topRight: const Radius.circular(20),
                    bottomLeft: Radius.circular(isUser ? 20 : 0),
                    bottomRight: Radius.circular(isUser ? 0 : 20),
                  ),
                  boxShadow: [
                    BoxShadow(color: Colors.black.withOpacity(0.04), blurRadius: 10, offset: const Offset(0, 4))
                  ],
                  border: isUser ? null : Border.all(color: Colors.teal.shade100, width: 1),
                ),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    isUser ? Text(
                      message.text,
                      style: const TextStyle(color: Colors.white, fontSize: 15),
                    ) : MarkdownBody(
                      data: message.text,
                      styleSheet: MarkdownStyleSheet(
                        p: const TextStyle(color: Colors.black87, fontSize: 15, height: 1.5),
                        strong: const TextStyle(fontWeight: FontWeight.bold, color: Colors.black87),
                        h3: TextStyle(fontWeight: FontWeight.bold, fontSize: 18, color: Colors.teal),
                        listBullet: const TextStyle(color: Colors.black87),
                      ),
                    ),
                    if (message.rekomendasiData != null) ...[
                      const SizedBox(height: 12),
                      Container(
                        padding: const EdgeInsets.all(12),
                        decoration: BoxDecoration(color: Colors.teal.shade50, borderRadius: BorderRadius.circular(12)),
                        child: Row(
                          children: [
                            const Icon(Icons.place, color: Colors.teal, size: 20),
                            const SizedBox(width: 8),
                            Expanded(
                              child: Text(
                                message.rekomendasiData['nama_tempat'] ?? 'Destinasi Terpilih',
                                style: const TextStyle(fontWeight: FontWeight.bold, color: Colors.black87),
                              ),
                            )
                          ],
                        ),
                      )
                    ]
                  ],
                ),
              ),
            ),
            if (isUser) ...[
              const SizedBox(width: 8),
              CircleAvatar(
                radius: 16,
                backgroundColor: Colors.teal.shade100,
                child: Icon(Icons.person, size: 20, color: Colors.teal.shade800),
              ),
            ],
          ],
        ),
      ),
    );
  }
}

class TypingIndicator extends StatefulWidget {
  const TypingIndicator({Key? key}) : super(key: key);
  @override
  _TypingIndicatorState createState() => _TypingIndicatorState();
}

class _TypingIndicatorState extends State<TypingIndicator> with SingleTickerProviderStateMixin {
  late AnimationController _controller;

  @override
  void initState() {
    super.initState();
    _controller = AnimationController(vsync: this, duration: const Duration(milliseconds: 1200))..repeat();
  }

  @override
  void dispose() {
    _controller.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Row(
      mainAxisSize: MainAxisSize.min,
      children: List.generate(3, (index) {
        return AnimatedBuilder(
          animation: _controller,
          builder: (context, child) {
            double val = (_controller.value * 3) - index;
            if (val < 0) val += 3;
            double opacity = val >= 0 && val <= 1 ? (1 - val) : 0.2;
            double translateY = val >= 0 && val <= 1 ? (val * -5) : 0;
            return Transform.translate(
              offset: Offset(0, translateY),
              child: Opacity(
                opacity: opacity + 0.2,
                child: Container(
                  margin: const EdgeInsets.symmetric(horizontal: 2),
                  width: 8,
                  height: 8,
                  decoration: const BoxDecoration(color: Colors.teal, shape: BoxShape.circle),
                ),
              ),
            );
          },
        );
      }),
    );
  }
}
