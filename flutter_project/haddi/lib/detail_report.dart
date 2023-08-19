import 'package:firebase_storage/firebase_storage.dart';
import 'package:flutter/material.dart';

class DetailReport extends StatefulWidget {
  final String id;
  final String alert;
  final String name;
  final String phone_no;
  final String extent;
  const DetailReport({Key? key,required this.id,required this.alert,required this.name,required this.phone_no,required this.extent}) : super(key: key);

  @override
  State<DetailReport> createState() => _DetailReportState();
}

class _DetailReportState extends State<DetailReport> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Detailed Report'),
      ),
      body: Column(
        children: [
          FutureBuilder(
            future: getImageURL(),
            builder: (context, snapshot) {
              if (snapshot.connectionState == ConnectionState.waiting) {
                return CircularProgressIndicator();
              }
              if (!snapshot.hasData) {
                return Text('Image not available');
              }
              String imageURL = snapshot.data.toString();
              return Image(
                image: NetworkImage(imageURL),
                width: double.infinity,
                height: 500,
                fit: BoxFit.cover,
              );
            },
          ),
          SizedBox(height: 20),
          KeyValueList(
            keyValuePairs: [
              KeyValuePair('Fracture', widget.alert),
              KeyValuePair('Name', widget.name),
              KeyValuePair('Phone-Number', widget.phone_no),
              KeyValuePair('Extent of Fracture', widget.extent),
            ],
          ),
        ],
      ),
    );
  }
  Future<String> getImageURL() async {
    final Reference ref = FirebaseStorage.instance.ref().child('id'+widget.id+'.jpg'); // Replace with your image path
    final String downloadURL = await ref.getDownloadURL();
    return downloadURL;
  }
}

class KeyValuePair {
  final String key;
  final String value;

  KeyValuePair(this.key, this.value);
}
class KeyValueList extends StatelessWidget {
  final List<KeyValuePair> keyValuePairs;

  KeyValueList({required this.keyValuePairs});

  @override
  Widget build(BuildContext context) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: keyValuePairs.map((pair) {
        return Padding(
          padding: const EdgeInsets.symmetric(vertical: 8.0, horizontal: 16.0),
          child: Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              Text(
                pair.key,
                style: TextStyle(fontWeight: FontWeight.bold),
              ),
              Text(pair.value),
            ],
          ),
        );
      }).toList(),
    );
  }
}
