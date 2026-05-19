import 'dart:async';
import 'package:camera/camera.dart';
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import '../providers/app_provider.dart';
import '../widgets/camera_overlay.dart';
import '../widgets/food_scan_sheet.dart';

class ScannerScreen extends StatefulWidget {
  const ScannerScreen({super.key});

  @override
  State<ScannerScreen> createState() => _ScannerScreenState();
}

class _ScannerScreenState extends State<ScannerScreen> with WidgetsBindingObserver {
  CameraController? _cameraController;
  List<CameraDescription>? _cameras;
  int _selectedCameraIndex = 0;
  bool _isCameraReady = false;

  @override
  void initState() {
    super.initState();
    WidgetsBinding.instance.addObserver(this);
    _initializeCamera();
  }

  @override
  void dispose() {
    WidgetsBinding.instance.removeObserver(this);
    _cameraController?.dispose();
    super.dispose();
  }

  @override
  void didChangeAppLifecycleState(AppLifecycleState state) {
    if (_cameraController == null || !_cameraController!.value.isInitialized) {
      return;
    }
    if (state == AppLifecycleState.inactive) {
      _cameraController?.dispose();
    } else if (state == AppLifecycleState.resumed) {
      _initializeCamera();
    }
  }

  /// Inisialisasi kamera dan set controller pertama
  Future<void> _initializeCamera() async {
    _cameras = await availableCameras();
    if (_cameras!.isEmpty) return;

    _cameraController = CameraController(
      _cameras![_selectedCameraIndex],
      ResolutionPreset.high,
      enableAudio: false,
    );

    await _cameraController?.initialize();
    setState(() {
      _isCameraReady = true;
    });
  }

  /// Berarti flash mode ON/OFF pada kamera
  void _toggleFlash() {
    if (_cameraController == null || !_cameraController!.value.isInitialized) return;
    final current = _cameraController!.value.flashMode;
    final nextMode = current == FlashMode.torch ? FlashMode.off : FlashMode.torch;
    _cameraController?.setFlashMode(nextMode);
    setState(() {});
  }

  void _switchCamera() {
    if (_cameras == null || _cameras!.length < 2) return;
    _selectedCameraIndex = (_selectedCameraIndex + 1) % _cameras!.length;
    _initializeCamera();
  }

  @override
  Widget build(BuildContext context) {
    final provider = context.watch<AppProvider>();

    return SafeArea(
      child: Stack(
        children: [
          _buildCameraPreview(),
          _buildOverlay(),
          _buildControls(provider),
          if (provider.scanResult != null) FoodScanSheet(scanResult: provider.scanResult!),
        ],
      ),
    );
  }

  Widget _buildCameraPreview() {
    if (!_isCameraReady || _cameraController == null) {
      return const Center(child: CircularProgressIndicator());
    }

    return CameraPreview(_cameraController!);
  }

  Widget _buildOverlay() {
    return const CameraOverlay();
  }

  Widget _buildControls(AppProvider provider) {
    return Positioned(
      bottom: 24,
      left: 0,
      right: 0,
      child: Padding(
        padding: const EdgeInsets.symmetric(horizontal: 20),
        child: Row(
          mainAxisAlignment: MainAxisAlignment.spaceBetween,
          children: [
            _controlButton(Icons.flash_on, _toggleFlash),
            GestureDetector(
              onTap: () async {
                await provider.scanFood();
              },
              child: Container(
                width: 78,
                height: 78,
                decoration: BoxDecoration(
                  shape: BoxShape.circle,
                  border: Border.all(color: Colors.white, width: 4),
                ),
                child: const Icon(Icons.camera, size: 32, color: Colors.white),
              ),
            ),
            _controlButton(Icons.cameraswitch, _switchCamera),
          ],
        ),
      ),
    );
  }

  Widget _controlButton(IconData icon, VoidCallback action) {
    return InkWell(
      onTap: action,
      customBorder: const CircleBorder(),
      child: Container(
        width: 52,
        height: 52,
        decoration: const BoxDecoration(
          shape: BoxShape.circle,
          color: Colors.black45,
        ),
        child: Icon(icon, color: Colors.white),
      ),
    );
  }
}
