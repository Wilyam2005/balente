import 'package:flutter/material.dart';

class RadiusFilter extends StatelessWidget {
  final String selectedLabel;
  final void Function(double value, String label) onChanged;

  const RadiusFilter({
    super.key,
    required this.selectedLabel,
    required this.onChanged,
  });

  @override
  Widget build(BuildContext context) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        const Text(
          'Filter Jarak',
          style: TextStyle(fontWeight: FontWeight.w600, fontSize: 16),
        ),
        const SizedBox(height: 10),
        Row(
          mainAxisAlignment: MainAxisAlignment.spaceBetween,
          children: [
            _radiusButton(context, '< 2 km', 2.0),
            _radiusButton(context, '< 5 km', 5.0),
            _radiusButton(context, '< 10 km', 10.0),
          ],
        ),
      ],
    );
  }

  Widget _radiusButton(BuildContext context, String label, double value) {
    final selected = selectedLabel == label;
    return Expanded(
      child: Padding(
        padding: const EdgeInsets.symmetric(horizontal: 4.0),
        child: ElevatedButton(
          onPressed: () => onChanged(value, label),
          style: ElevatedButton.styleFrom(
            backgroundColor: selected ? Colors.teal.shade700 : Colors.grey.shade200,
            foregroundColor: selected ? Colors.white : Colors.grey.shade800,
            shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(16)),
            elevation: 0,
          ),
          child: Text(label),
        ),
      ),
    );
  }
}
