

import 'package:firebase_database/firebase_database.dart';
import 'package:firebase_database/ui/firebase_animated_list.dart';
import 'package:flutter/material.dart';
import 'package:haddi/detail_report.dart';

class HomePage extends StatefulWidget {
  const HomePage({Key? key}) : super(key: key);

  @override
  State<HomePage> createState() => _HomePageState();
}

class _HomePageState extends State<HomePage> {
  Query ref = FirebaseDatabase.instance.ref('patients');


  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        backgroundColor: Colors.blueGrey,
        title: Text('Patients list'),
      ),
      body: Padding(
        padding: const EdgeInsets.all(10.0),
        child: Column(
          children: [
            Expanded(
                child: FirebaseAnimatedList(query: ref, itemBuilder: (context,snapshot,animation,index){
                  return Container(
                    decoration: BoxDecoration(
                      border: Border.all(

                          color: Colors.black45,
                          width: 4.0,

                      ),
                    ),
                    child: ListTile(
                      title: Text(snapshot.child('name').value.toString()),
                      subtitle: Text(snapshot.child('address').value.toString()),
                      trailing: InkWell(
                        onTap: (){
                          Navigator.push(context, MaterialPageRoute(builder: (context)=>DetailReport(id: snapshot.child('id').value.toString(),alert: snapshot.child('fracture').value.toString(),name: snapshot.child('name').value.toString(),phone_no: snapshot.child('phone').value.toString(),extent: snapshot.child('extent').value.toString(),)));
                        },
                        child: Icon(Icons.arrow_forward),
                      ),

                    ),
                  );
                })
            ),
          ],
        ),
      ),
    );
  }
}

