import 'package:flutter/material.dart';

class QuickReplyBar extends StatelessWidget {
  final List<String> replies;
  final ValueChanged<String> onTap;

  const QuickReplyBar({
    super.key,
    required this.replies,
    required this.onTap,
  });

  @override
  Widget build(BuildContext context) {
    return SizedBox(
      height: 48,
      child: ListView.separated(
        scrollDirection: Axis.horizontal,
        padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
        itemCount: replies.length,
        separatorBuilder: (_, __) => const SizedBox(width: 12),
        itemBuilder: (context, index) {
          final label = replies[index];
          return ActionChip(
            label: Text(label),
            onPressed: () => onTap(label),
            backgroundColor: Colors.teal.shade50,
            labelStyle: TextStyle(color: Colors.teal.shade800),
          );
        },
      ),
    );
  }
}
