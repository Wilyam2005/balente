class Destination {
  final String id;
  final String category;
  final String name;
  final String imageUrl;
  final double latitude;
  final double longitude;
  final double rating;
  final String description;
  final double distanceKm;

  Destination({
    required this.id,
    required this.category,
    required this.name,
    required this.imageUrl,
    required this.latitude,
    required this.longitude,
    required this.rating,
    required this.description,
    required this.distanceKm,
  });

  Destination copyWith({double? distanceKm}) {
    return Destination(
      id: id,
      category: category,
      name: name,
      imageUrl: imageUrl,
      latitude: latitude,
      longitude: longitude,
      rating: rating,
      description: description,
      distanceKm: distanceKm ?? this.distanceKm,
    );
  }
}
