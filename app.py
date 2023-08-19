from flask import Flask,request,render_template,Response,redirect
import numpy as np
import matplotlib.pyplot as plt
import torchvision.transforms as T
from sklearn.model_selection import train_test_split
import datetime
import torch
import torchvision
from torchvision import transforms
from torchvision.datasets import ImageFolder
from torch.utils.data import DataLoader,TensorDataset
import torch.nn as nn
import torch
import torch.nn.functional as F
import random
from PIL import Image
import os 
import subprocess as sp
import firebase_admin
from firebase_admin import credentials,storage
# app.config.from_object(Config)
from dotenv import load_dotenv
load_dotenv()
cred = credentials.Certificate(os.getenv('firebasejson'))
firebase_admin.initialize_app(cred,{'storageBucket':os.getenv('storageURL')})

import pyrebase
config = {
  "apiKey": "PASTE_HERE",
  "authDomain": "PASTE_HERE",
  "databaseURL": os.getenv('databaseURL'),
  "storageBucket": os.getenv('storageURL')
}
firebase = pyrebase.initialize_app(config)
auth = firebase.auth()
db = firebase.database()
storage1=firebase.storage()
url=os.getenv('storageURL')
app=Flask(__name__)

class xrayNet(nn.Module):
    def __init__(self):
      super().__init__()

      ### convolution layers
      self.conv1 = nn.Conv2d( 3,10,kernel_size=5,stride=1,padding=1)


      self.conv2 = nn.Conv2d(10,20,kernel_size=5,stride=1,padding=1)
      # size: 54

      # compute the number of units in FClayer (number of outputs of conv2)
      expectSize = np.floor( (54+2*0-1)/1 ) + 1 # fc1 layer has no padding or kernel, so set to 0/1
      expectSize = 20*int(expectSize**2)

      ### fully-connected layer
      self.fc1 = nn.Linear(expectSize,50)

      ### output layer
      self.out = nn.Linear(50,2)


    #   self.print = printtoggle

    # forward pass
    def forward(self,x):

    #   print(f'Input: {x.shape}') if self.print else None

      # convolution -> maxpool -> relu
      x = F.relu(F.max_pool2d(self.conv1(x),2))
    #   print(f'Layer conv1/pool1: {x.shape}') if self.print else None


      x = F.relu(F.max_pool2d(self.conv2(x),2))
    #   print(f'Layer conv2/pool2: {x.shape}') if self.print else None

      # reshape for linear layer
      nUnits = x.shape.numel()/x.shape[0]
      x = x.view(-1,int(nUnits))
    #   if self.print: print(f'Vectorize: {x.shape}')

      
      x = F.relu(self.fc1(x))
    #   if self.print: print(f'Layer fc1: {x.shape}')
      x = self.out(x)
    #   if self.print: print(f'Layer out: {x.shape}')

      return x
    
model = xrayNet()
model.load_state_dict(torch.load("model.pt"))

@app.route('/',methods=['GET','POST'])
def index():
    username= request.args.get('pid')
    patient =db.child("patients").child(username).get()
    data = patient.val() 
    
    # d=sp.getoutput("python process_image.py 00000001_000.png")
    # d.split(' ')
    # print(d)
    # d=d[d.find('Fracture')+10:d.find('Fracture')+20]
    # print(float(d))
    if request.method =='POST':

        
        

      f=request.files['file']
      f.save(f.filename)
      d=sp.getoutput("python torchxrayvision\scripts\process_image.py "+str(f.filename))
      d.split(' ')
      print(d)
      d=d[d.find('Fracture')+10:d.find('Fracture')+16]
      
      
      
      bucket = storage.bucket() # storage bucket
      blob = bucket.blob(str(f.filename))
      blob.upload_from_filename(str(f.filename))
      blob.make_public()
      img = Image.open(str(f.filename))
      preprocess = T.Compose([
      T.Resize(224),
          T.ToTensor()])
      
      x = preprocess(img)
      
      print(len(x))
      yhat=model(torch.tensor(np.array([x.tolist()])).float())
      y=torch.argmax(yhat,axis=1)
      if(y.tolist()[0]==0):
         
        #  data['extent']=d
         json_data = {'fracture':True,'extent':str(d)} 
         u = db.child("patients").child(username).update(json_data)
         pass
         #fracture is there
      else:
         json_data = {'fracture':False} 
         u = db.child("patients").child(username).update(json_data)
         pass
         #fracture not there
      patient =db.child("patients").child(username).get()
      data = patient.val()
      
      a=blob.generate_signed_url(datetime.timedelta(seconds=300), method='GET')
      print(a)
      data['image']=a
      
      return render_template('result.html',userdetails=data)
    else:
      return render_template('patient_details.html',userdetails=data)
       
        
    # if(y.tolist()[0]==0):
    #    json_data = {'alert':'true'} 
    #    u = db.child("contact").child(username).update(json_data)
    #    pass
    #    #fracture is there
    # else:
    #    json_data = {'alert':'true'} 
    #    u = db.child("contact").child(username).update(json_data)
    #    pass
    #    #fracture not there
       
    # json_data = {'alert':'true'} 
    # u = db.child("contact").child(username).update(json_data)
    # return render_template('patient_details.html',userdetails=data)




       
    
    
    
      
    
   

   












if __name__=='__main__':
    app.run(debug=True)


