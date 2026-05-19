import 'destination.dart';

class ChatMessage {
  final String text;
  final bool isUser;
  final Destination? recommendedDestination;

  ChatMessage({
    required this.text,
    required this.isUser,
    this.recommendedDestination,
  });
}
