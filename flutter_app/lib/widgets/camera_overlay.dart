import 'package:flutter/material.dart';

class CameraOverlay extends StatelessWidget {
  const CameraOverlay({super.key});

  @override
  Widget build(BuildContext context) {
    return Stack(
      children: [
        Container(
          color: Colors.black26,
        ),
        Center(
          child: Container(
            width: MediaQuery.of(context).size.width * 0.78,
            height: MediaQuery.of(context).size.width * 0.78,
            decoration: BoxDecoration(
              border: Border.all(color: Colors.teal.shade400, width: 3),
              borderRadius: BorderRadius.circular(24),
            ),
          ),
        ),
        Positioned.fill(
          child: IgnorePointer(
            child: CustomPaint(
              painter: _ScannerLinePainter(),
            ),
          ),
        ),
      ],
    );
  }
}

class _ScannerLinePainter extends CustomPainter {
  @override
  void paint(Canvas canvas, Size size) {
    final paint = Paint()
      ..color = Colors.tealAccent.withAlpha((0.7 * 255).toInt())
      ..strokeWidth = 3;

    final y = size.height * 0.5;
    canvas.drawLine(Offset(size.width * 0.12, y), Offset(size.width * 0.88, y), paint);
  }

  @override
  bool shouldRepaint(covariant CustomPainter oldDelegate) => false;
}
