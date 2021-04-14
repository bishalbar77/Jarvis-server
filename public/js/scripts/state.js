
var handles = ["Select state","Andhra Pradesh","Arunachal Pradesh","Assam","Bihar","Chhattisgarh","Dadra and Nagar Haveli","Daman and Diu","Delhi","Goa","Gujarat","Haryana","Himachal Pradesh","Jammu and Kashmir","Jharkhand","Karnataka",
                                        "Kerala","Madhya Pradesh","Maharashtra","Manipur","Meghalaya","Mizoram","Nagaland","Orissa","Puducherry","Punjab", "Rajasthan","Sikkim","Tamil Nadu",
                                        "Telangana","Tripura","Uttar Pradesh","Uttarakhand","West Bengal"];

$(function() {
  var options = '';
  for (var i = 0; i < handles.length; i++) {
      options += '<option value="' + handles[i] + '">' + handles[i] + '</option>';
  }
  $('#choosestate').html(options);
});

var handless = ["Select state","Andhra Pradesh","Arunachal Pradesh","Assam","Bihar","Chhattisgarh","Dadra and Nagar Haveli","Daman and Diu","Delhi","Goa","Gujarat","Haryana","Himachal Pradesh","Jammu and Kashmir","Jharkhand","Karnataka",
                                        "Kerala","Madhya Pradesh","Maharashtra","Manipur","Meghalaya","Mizoram","Nagaland","Orissa","Puducherry","Punjab", "Rajasthan","Sikkim","Tamil Nadu",
                                        "Telangana","Tripura","Uttar Pradesh","Uttarakhand","West Bengal"];

$(function() {
  var optionss = '';
  for (var i = 0; i < handless.length; i++) {
      optionss += '<option value="' + handless[i] + '">' + handless[i] + '</option>';
  }
  $('#pchoosestate').html(optionss);
});



function selct_district($val)
{
    if($val=='Select state') {
   var options = '';
  $('#district').html(options);
  }
 if($val=='Andhra Pradesh') {
   var andhra = ["Select district","Anantapur","Chittoor","East Godavari","Guntur","Krishna","Kurnool","Prakasam","Srikakulam","SriPotti Sri Ramulu Nellore",
                                    "Vishakhapatnam","Vizianagaram","West Godavari","Cudappah"];
   $(function() {
  var options = '';
  for (var i = 0; i < andhra.length; i++) {
      options += '<option value="' + andhra[i] + '">' + andhra[i] + '</option>';
  }
  $('#district').html(options);
  });
  }
  
  if ($val=='Arunachal Pradesh') {
    var ap = ["Select district","Anjaw","Changlang","Dibang Valley","East Siang","East Kameng","Kurung Kumey","Lohit","Longding","Lower Dibang Valley","Lower Subansiri","Papum Pare",
                                        "Tawang","Tirap","Upper Siang","Upper Subansiri","West Kameng","West Siang"];
   $(function() {
  var options = '';
  for (var i = 0; i < ap.length; i++) {
      options += '<option value="' + ap[i] + '">' + ap[i] + '</option>';
  }
  $('#district').html(options);
  });
  }
  
  if ($val=='Assam') {
    var assam = ["Select district","Baksa","Barpeta","Bongaigaon","Cachar","Chirang","Darrang","Dhemaji","Dima Hasao","Dhubri","Dibrugarh","Goalpara","Golaghat","Hailakandi","Jorhat",
                                     "Kamrup","Kamrup Metropolitan","Karbi Anglong","Karimganj","Kokrajhar","Lakhimpur","Morigaon","Nagaon","Nalbari","Sivasagar","Sonitpur","Tinsukia","Udalguri"];
   $(function() {
  var options = '';
  for (var i = 0; i < assam.length; i++) {
      options += '<option value="' + assam[i] + '">' + assam[i] + '</option>';
  }
  $('#district').html(options);
  });
  }
  
  if ($val=='Bihar') {
    var bihar = ["Select district","Araria","Arwal","Aurangabad","Banka","Begusarai","Bhagalpur","Bhojpur","Buxar","Darbhanga","East Champaran","Gaya","Gopalganj","Jamui","Jehanabad","Kaimur",
                                        "Katihar","Khagaria","Kishanganj","Lakhisarai","Madhepura","Madhubani","Munger","Muzaffarpur","Nalanda","Nawada","Patna","Purnia","Rohtas","Saharsa",
                                        "Samastipur","Saran","Sheikhpura","Sheohar","Sitamarhi","Siwan","Supaul","Vaishali","West Champaran"];
   $(function() {
  var options = '';
  for (var i = 0; i < bihar.length; i++) {
      options += '<option value="' + bihar[i] + '">' + bihar[i] + '</option>';
  }
  $('#district').html(options);
  });
  }
  
  if ($val=='Chhattisgarh') {
    var Chhattisgarh = ["Select district","Bastar","Bijapur","Bilaspur","Dantewada","Dhamtari","Durg","Jashpur","Janjgir-Champa","Korba","Koriya","Kanker","Kabirdham (formerly Kawardha)","Mahasamund",
                                            "Narayanpur","Raigarh","Rajnandgaon","Raipur","Surajpur","Surguja"];
   $(function() {
  var options = '';
  for (var i = 0; i < Chhattisgarh.length; i++) {
      options += '<option value="' + Chhattisgarh[i] + '">' + Chhattisgarh[i] + '</option>';
  }
  $('#district').html(options);
  });
  }
  
  if ($val=='Dadra and Nagar Haveli') {
    var dadra = ["Select district","Amal","Silvassa"];
   $(function() {
  var options = '';
  for (var i = 0; i < dadra.length; i++) {
      options += '<option value="' + dadra[i] + '">' + dadra[i] + '</option>';
  }
  $('#district').html(options);
  });
  }
  
  if ($val=='Daman and Diu') {
    var daman = ["Select district","Daman","Diu"];
   $(function() {
  var options = '';
  for (var i = 0; i < daman.length; i++) {
      options += '<option value="' + daman[i] + '">' + daman[i] + '</option>';
  }
  $('#district').html(options);
  });
  }
  
  if ($val=='Delhi') {
    var delhi = ["Select district","Delhi","New Delhi","North Delhi","Noida","Patparganj","Sonabarsa","Tughlakabad"];
   $(function() {
  var options = '';
  for (var i = 0; i < delhi.length; i++) {
      options += '<option value="' + delhi[i] + '">' + delhi[i] + '</option>';
  }
  $('#district').html(options);
  });
  }
  
  if ($val=='Goa') {
    var goa = ["Select district","Chapora","Dabolim","Madgaon","Marmugao (Marmagao)","Panaji Port","Panjim","Pellet Plant Jetty/Shiroda","Talpona","Vasco da Gama"];
   $(function() {
  var options = '';
  for (var i = 0; i < goa.length; i++) {
      options += '<option value="' + goa[i] + '">' + goa[i] + '</option>';
  }
  $('#district').html(options);
  });
  }
  
  if ($val=='Gujarat') {
    var gujarat = ["Select district","Ahmedabad","Amreli district","Anand","Aravalli","Banaskantha","Bharuch","Bhavnagar","Dahod","Dang","Gandhinagar","Jamnagar","Junagadh",
                                        "Kutch","Kheda","Mehsana","Narmada","Navsari","Patan","Panchmahal","Porbandar","Rajkot","Sabarkantha","Surendranagar","Surat","Tapi","Vadodara","Valsad"];
   $(function() {
  var options = '';
  for (var i = 0; i < gujarat.length; i++) {
      options += '<option value="' + gujarat[i] + '">' + gujarat[i] + '</option>';
  }
  $('#district').html(options);
  });
  }
  
  if ($val=='Haryana') {
    var haryana = ["Select district","Ambala","Bhiwani","Faridabad","Fatehabad","Gurgaon","Hissar","Jhajjar","Jind","Karnal","Kaithal",
                                            "Kurukshetra","Mahendragarh","Mewat","Palwal","Panchkula","Panipat","Rewari","Rohtak","Sirsa","Sonipat","Yamuna Nagar"];
   $(function() {
  var options = '';
  for (var i = 0; i < haryana.length; i++) {
      options += '<option value="' + haryana[i] + '">' + haryana[i] + '</option>';
  }
  $('#district').html(options);
  });
  }
  
  
  if ($val=='Himachal Pradesh') {
    var himachal = ["Select district","Baddi","Baitalpur","Chamba","Dharamsala","Hamirpur","Kangra","Kinnaur","Kullu","Lahaul & Spiti","Mandi","Simla","Sirmaur","Solan","Una"];
   $(function() {
  var options = '';
  for (var i = 0; i < himachal.length; i++) {
      options += '<option value="' + himachal[i] + '">' + himachal[i] + '</option>';
  }
  $('#district').html(options);
  });
  }
  
  if ($val=='Jammu and Kashmir') {
    var jammu = ["Select district","Jammu","Leh","Rajouri","Srinagar"];
   $(function() {
  var options = '';
  for (var i = 0; i < jammu.length; i++) {
      options += '<option value="' + jammu[i] + '">' + jammu[i] + '</option>';
  }
  $('#district').html(options);
  });
  }
  
  if ($val=='Jharkhand') {
    var jharkhand = ["Select district","Bokaro","Chatra","Deoghar","Dhanbad","Dumka","East Singhbhum","Garhwa","Giridih","Godda","Gumla","Hazaribag","Jamtara","Khunti","Koderma","Latehar","Lohardaga","Pakur","Palamu",
                                            "Ramgarh","Ranchi","Sahibganj","Seraikela Kharsawan","Simdega","West Singhbhum"];
   $(function() {
  var options = '';
  for (var i = 0; i < jharkhand.length; i++) {
      options += '<option value="' + jharkhand[i] + '">' + jharkhand[i] + '</option>';
  }
  $('#district').html(options);
  });
  }
  
  if ($val=='Karnataka') {
    var karnataka = ["Select district","Bagalkot","Bangalore","Bangalore Urban","Belgaum","Bellary","Bidar","Bijapur","Chamarajnagar", "Chikkamagaluru","Chikkaballapur",
                                           "Chitradurga","Davanagere","Dharwad","Dakshina Kannada","Gadag","Gulbarga","Hassan","Haveri district","Kodagu",
                                           "Kolar","Koppal","Mandya","Mysore","Raichur","Shimoga","Tumkur","Udupi","Uttara Kannada","Ramanagara","Yadgir"];
   $(function() {
  var options = '';
  for (var i = 0; i < karnataka.length; i++) {
      options += '<option value="' + karnataka[i] + '">' + karnataka[i] + '</option>';
  }
  $('#district').html(options);
  });
  }
  
  if ($val=='Kerala') {
    var kerala = ["Select district","Alappuzha","Ernakulam","Idukki","Kannur","Kasaragod","Kollam","Kottayam","Kozhikode","Malappuram","Palakkad","Pathanamthitta","Thrissur","Thiruvananthapuram","Wayanad"];
   $(function() {
  var options = '';
  for (var i = 0; i < kerala.length; i++) {
      options += '<option value="' + kerala[i] + '">' + kerala[i] + '</option>';
  }
  $('#district').html(options);
  });
  }
  
  if ($val=='Madhya Pradesh') {
    var mp = ["Select district","Alirajpur","Anuppur","Ashoknagar","Balaghat","Barwani","Betul","Bhilai","Bhind","Bhopal","Burhanpur","Chhatarpur","Chhindwara","Damoh","Dewas","Dhar","Guna","Gwalior","Hoshangabad",
                                    "Indore","Itarsi","Jabalpur","Khajuraho","Khandwa","Khargone","Malanpur","Malanpuri (Gwalior)","Mandla","Mandsaur","Morena","Narsinghpur","Neemuch","Panna","Pithampur","Raipur","Raisen","Ratlam",
                                    "Rewa","Sagar","Satna","Sehore","Seoni","Shahdol","Singrauli","Ujjain"];
   $(function() {
  var options = '';
  for (var i = 0; i < mp.length; i++) {
      options += '<option value="' + mp[i] + '">' + mp[i] + '</option>';
  }
  $('#district').html(options);
  });
  }
  
  if ($val=='Maharashtra') {
    var maharashtra = ["Select district","Ahmednagar","Akola","Alibag","Amaravati","Arnala","Aurangabad","Aurangabad","Bandra","Bassain","Belapur","Bhiwandi","Bhusaval","Borliai-Mandla","Chandrapur","Dahanu","Daulatabad","Dighi (Pune)","Dombivali","Goa","Jaitapur","Jalgaon",
                                             "Jawaharlal Nehru (Nhava Sheva)","Kalyan","Karanja","Kelwa","Khopoli","Kolhapur","Lonavale","Malegaon","Malwan","Manori",
                                             "Mira Bhayandar","Miraj","Mumbai (ex Bombay)","Murad","Nagapur","Nagpur","Nalasopara","Nanded","Nandgaon","Nasik","Navi Mumbai","Nhave","Osmanabad","Palghar",
                                             "Panvel","Pimpri","Pune","Ratnagiri","Sholapur","Shrirampur","Shriwardhan","Tarapur","Thana","Thane","Trombay","Varsova","Vengurla","Virar","Wada"];
   $(function() {
  var options = '';
  for (var i = 0; i < maharashtra.length; i++) {
      options += '<option value="' + maharashtra[i] + '">' + maharashtra[i] + '</option>';
  }
  $('#district').html(options);
  });
  }
  
   if ($val=='Manipur') {
    var manipur = ["Select district","Bishnupur","Churachandpur","Chandel","Imphal East","Senapati","Tamenglong","Thoubal","Ukhrul","Imphal West"];
   $(function() {
  var options = '';
  for (var i = 0; i < manipur.length; i++) {
      options += '<option value="' + manipur[i] + '">' + manipur[i] + '</option>';
  }
  $('#district').html(options);
  });
  }
  
   if ($val=='Meghalaya') {
    var meghalaya = ["Select district","Baghamara","Balet","Barsora","Bolanganj","Dalu","Dawki","Ghasuapara","Mahendraganj","Moreh","Ryngku","Shella Bazar","Shillong"];
   $(function() {
  var options = '';
  for (var i = 0; i < meghalaya.length; i++) {
      options += '<option value="' + meghalaya[i] + '">' + meghalaya[i] + '</option>';
  }
  $('#district').html(options);
  });
  }
  
   if ($val=='Mizoram') {
    var mizoram = ["Select district","Aizawl","Champhai","Kolasib","Lawngtlai","Lunglei","Mamit","Saiha","Serchhip"];
   $(function() {
  var options = '';
  for (var i = 0; i < mizoram.length; i++) {
      options += '<option value="' + mizoram[i] + '">' + mizoram[i] + '</option>';
  }
  $('#district').html(options);
  });
  }
  
   if ($val=='Nagaland') {
    var nagaland = ["Select district","Dimapur","Kiphire","Kohima","Longleng","Mokokchung","Mon","Peren","Phek","Tuensang","Wokha","Zunheboto"];
   $(function() {
  var options = '';
  for (var i = 0; i < nagaland.length; i++) {
      options += '<option value="' + nagaland[i] + '">' + nagaland[i] + '</option>';
  }
  $('#district').html(options);
  });
  }
  
  if ($val=='Orissa') {
    var orissa = ["Select district","Bahabal Pur","Bhubaneswar","Chandbali","Gopalpur","Jeypore","Paradip Garh","Puri","Rourkela"];
   $(function() {
  var options = '';
  for (var i = 0; i < orissa.length; i++) {
      options += '<option value="' + orissa[i] + '">' + orissa[i] + '</option>';
  }
  $('#district').html(options);
  });
  }
  
  if ($val=='Puducherry') {
    var puducherry = ["Select district","Karaikal","Mahe","Pondicherry","Yanam"];
   $(function() {
  var options = '';
  for (var i = 0; i < puducherry.length; i++) {
      options += '<option value="' + puducherry[i] + '">' + puducherry[i] + '</option>';
  }
  $('#district').html(options);
  });
  }
  
  if ($val=='Punjab') {
    var punjab = ["Select district","Amritsar","Barnala","Bathinda","Firozpur","Faridkot","Fatehgarh Sahib","Fazilka","Gurdaspur","Hoshiarpur","Jalandhar","Kapurthala","Ludhiana","Mansa","Moga","Sri Muktsar Sahib","Pathankot",
                                        "Patiala","Rupnagar","Ajitgarh (Mohali)","Sangrur","Shahid Bhagat Singh Nagar","Tarn Taran"];
   $(function() {
  var options = '';
  for (var i = 0; i < punjab.length; i++) {
      options += '<option value="' + punjab[i] + '">' + punjab[i] + '</option>';
  }
  $('#district').html(options);
  });
  }
  
  if ($val=='Rajasthan') {
    var rajasthan = ["Select district","Ajmer","Banswara","Barmer","Barmer Rail Station","Basni","Beawar","Bharatpur","Bhilwara","Bhiwadi","Bikaner","Bongaigaon","Boranada, Jodhpur","Chittaurgarh","Fazilka","Ganganagar","Jaipur","Jaipur-Kanakpura",
                                       "Jaipur-Sitapura","Jaisalmer","Jodhpur","Jodhpur-Bhagat Ki Kothi","Jodhpur-Thar","Kardhan","Kota","Munabao Rail Station","Nagaur","Rajsamand","Sawaimadhopur","Shahdol","Shimoga","Tonk","Udaipur"];
   $(function() {
  var options = '';
  for (var i = 0; i < rajasthan.length; i++) {
      options += '<option value="' + rajasthan[i] + '">' + rajasthan[i] + '</option>';
  }
  $('#district').html(options);
  });
  }
  
  if ($val=='Sikkim') {
    var sikkim = ["Select district","Chamurci","Gangtok"];
   $(function() {
  var options = '';
  for (var i = 0; i < sikkim.length; i++) {
      options += '<option value="' + sikkim[i] + '">' + sikkim[i] + '</option>';
  }
  $('#district').html(options);
  });
  }
  
  
  if ($val=='Tamil Nadu') {
    var tn = ["Select district","Ariyalur","Chennai","Coimbatore","Cuddalore","Dharmapuri","Dindigul","Erode","Kanchipuram","Kanyakumari","Karur","Krishnagiri","Madurai","Mandapam","Nagapattinam","Nilgiris","Namakkal","Perambalur","Pudukkottai","Ramanathapuram","Salem","Sivaganga","Thanjavur","Thiruvallur","Tirupur",
                                   "Tiruchirapalli","Theni","Tirunelveli","Thanjavur","Thoothukudi","Tiruvallur","Tiruvannamalai","Vellore","Villupuram","Viruthunagar"];
   $(function() {
  var options = '';
  for (var i = 0; i < tn.length; i++) {
      options += '<option value="' + tn[i] + '">' + tn[i] + '</option>';
  }
  $('#district').html(options);
  });
  }
  
  
  if ($val=='Telangana') {
    var telangana = ["Select district","Adilabad","Hyderabad","Karimnagar","Mahbubnagar","Medak","Nalgonda","Nizamabad","Ranga Reddy","Warangal"];
   $(function() {
  var options = '';
  for (var i = 0; i < telangana.length; i++) {
      options += '<option value="' + telangana[i] + '">' + telangana[i] + '</option>';
  }
  $('#district').html(options);
  });
  }
  
  
  if ($val=='Tripura') {
    var tripura = ["Select district","Agartala","Dhalaighat","Kailashahar","Kamalpur","Kanchanpur","Kel Sahar Subdivision","Khowai","Khowaighat","Mahurighat","Old Raghna Bazar","Sabroom","Srimantapur"];
   $(function() {
  var options = '';
  for (var i = 0; i < tripura.length; i++) {
      options += '<option value="' + tripura[i] + '">' + tripura[i] + '</option>';
  }
  $('#district').html(options);
  });
  }
  
  
  if ($val=='Uttar Pradesh') {
    var up = ["Select district","Agra","Allahabad","Auraiya","Azamgarh","Banbasa","Ballia","Bareilly","Berhni","Bhadohi","Dadri","Dharchula","Gandhar","Gauriphanta","Ghaziabad","Gorakhpur","Gunji",
                                    "Jarwa","Jhulaghat (Pithoragarh)","Kanpur","Katarniyaghat","Khunwa","Loni","Lucknow","Mahoba","Meerut","Moradabad","Muzaffarnagar","Nepalgunj Road","Pakwara (Moradabad)",
                                    "Pantnagar","Saharanpur","Sonauli","Surajpur","Tikonia","Varanasi"];
   $(function() {
  var options = '';
  for (var i = 0; i < up.length; i++) {
      options += '<option value="' + up[i] + '">' + up[i] + '</option>';
  }
  $('#district').html(options);
  });
  }
  
  
  if ($val=='Uttarakhand') {
    var uttarakhand = ["Select district","Almora","Badrinath","Bangla","Barkot","Bazpur","Chamoli","Chopra","Dehra Dun","Dwarahat","Garhwal","Haldwani","Hardwar","Haridwar","Jamal","Jwalapur","Kalsi","Kashipur","Mall",
                                           "Mussoorie","Nahar","Naini","Pantnagar","Pauri","Pithoragarh","Rameshwar","Rishikesh","Rohni","Roorkee","Sama","Saur"];
   $(function() {
  var options = '';
  for (var i = 0; i < uttarakhand.length; i++) {
      options += '<option value="' + uttarakhand[i] + '">' + uttarakhand[i] + '</option>';
  }
  $('#district').html(options);
  });
  }
  
  
  if ($val=='West Bengal') {
    var wb = ["Select district","Alipurduar","Bankura","Bardhaman","Birbhum","Cooch Behar","Dakshin Dinajpur","Darjeeling","Hooghly","Howrah",
                                    "Jalpaiguri","Kolkata","Maldah","Murshidabad","Nadia","North 24 Parganas","Paschim Medinipur","Purba Medinipur","Purulia","South 24 Parganas","Uttar Dinajpur"];
   $(function() {
  var options = '';
  for (var i = 0; i < wb.length; i++) {
      options += '<option value="' + wb[i] + '">' + wb[i] + '</option>';
  }
  $('#district').html(options);
  });
  }
  
}

function selct_pdistrict($val)
{
    if($val=='Select state') {
   var optionss = '';
  $('#pdistrict').html(optionss);
  }
 if($val=='Andhra Pradesh') {
   var andhra = ["Anantapur","Chittoor","East Godavari","Guntur","Krishna","Kurnool","Prakasam","Srikakulam","SriPotti Sri Ramulu Nellore",
                                    "Vishakhapatnam","Vizianagaram","West Godavari","Cudappah"];
   $(function() {
  var optionss = '';
  for (var i = 0; i < andhra.length; i++) {
      optionss += '<option value="' + andhra[i] + '">' + andhra[i] + '</option>';
  }
  $('#pdistrict').html(optionss);
  });
  }
  
  if ($val=='Arunachal Pradesh') {
    var ap = ["Anjaw","Changlang","Dibang Valley","East Siang","East Kameng","Kurung Kumey","Lohit","Longding","Lower Dibang Valley","Lower Subansiri","Papum Pare",
                                        "Tawang","Tirap","Upper Siang","Upper Subansiri","West Kameng","West Siang"];
   $(function() {
  var optionss = '';
  for (var i = 0; i < ap.length; i++) {
      optionss += '<option value="' + ap[i] + '">' + ap[i] + '</option>';
  }
  $('#pdistrict').html(optionss);
  });
  }
  
  if ($val=='Assam') {
    var assam = ["Baksa","Barpeta","Bongaigaon","Cachar","Chirang","Darrang","Dhemaji","Dima Hasao","Dhubri","Dibrugarh","Goalpara","Golaghat","Hailakandi","Jorhat",
                                     "Kamrup","Kamrup Metropolitan","Karbi Anglong","Karimganj","Kokrajhar","Lakhimpur","Morigaon","Nagaon","Nalbari","Sivasagar","Sonitpur","Tinsukia","Udalguri"];
   $(function() {
  var optionss = '';
  for (var i = 0; i < assam.length; i++) {
      optionss += '<option value="' + assam[i] + '">' + assam[i] + '</option>';
  }
  $('#pdistrict').html(optionss);
  });
  }
  
  if ($val=='Bihar') {
    var bihar = ["Araria","Arwal","Aurangabad","Banka","Begusarai","Bhagalpur","Bhojpur","Buxar","Darbhanga","East Champaran","Gaya","Gopalganj","Jamui","Jehanabad","Kaimur",
                                        "Katihar","Khagaria","Kishanganj","Lakhisarai","Madhepura","Madhubani","Munger","Muzaffarpur","Nalanda","Nawada","Patna","Purnia","Rohtas","Saharsa",
                                        "Samastipur","Saran","Sheikhpura","Sheohar","Sitamarhi","Siwan","Supaul","Vaishali","West Champaran"];
   $(function() {
  var optionss = '';
  for (var i = 0; i < bihar.length; i++) {
      optionss += '<option value="' + bihar[i] + '">' + bihar[i] + '</option>';
  }
  $('#pdistrict').html(optionss);
  });
  }
  
  if ($val=='Chhattisgarh') {
    var Chhattisgarh = ["Bastar","Bijapur","Bilaspur","Dantewada","Dhamtari","Durg","Jashpur","Janjgir-Champa","Korba","Koriya","Kanker","Kabirdham (formerly Kawardha)","Mahasamund",
                                            "Narayanpur","Raigarh","Rajnandgaon","Raipur","Surajpur","Surguja"];
   $(function() {
  var optionss = '';
  for (var i = 0; i < Chhattisgarh.length; i++) {
      optionss += '<option value="' + Chhattisgarh[i] + '">' + Chhattisgarh[i] + '</option>';
  }
  $('#pdistrict').html(optionss);
  });
  }
  
  if ($val=='Dadra and Nagar Haveli') {
    var dadra = ["Amal","Silvassa"];
   $(function() {
  var optionss = '';
  for (var i = 0; i < dadra.length; i++) {
      optionss += '<option value="' + dadra[i] + '">' + dadra[i] + '</option>';
  }
  $('#pdistrict').html(optionss);
  });
  }
  
  if ($val=='Daman and Diu') {
    var daman = ["Daman","Diu"];
   $(function() {
  var optionss = '';
  for (var i = 0; i < daman.length; i++) {
      optionss += '<option value="' + daman[i] + '">' + daman[i] + '</option>';
  }
  $('#pdistrict').html(optionss);
  });
  }
  
  if ($val=='Delhi') {
    var delhi = ["Delhi","New Delhi","North Delhi","Noida","Patparganj","Sonabarsa","Tughlakabad"];
   $(function() {
  var optionss = '';
  for (var i = 0; i < delhi.length; i++) {
      optionss += '<option value="' + delhi[i] + '">' + delhi[i] + '</option>';
  }
  $('#pdistrict').html(optionss);
  });
  }
  
  if ($val=='Goa') {
    var goa = ["Chapora","Dabolim","Madgaon","Marmugao (Marmagao)","Panaji Port","Panjim","Pellet Plant Jetty/Shiroda","Talpona","Vasco da Gama"];
   $(function() {
  var optionss = '';
  for (var i = 0; i < goa.length; i++) {
      optionss += '<option value="' + goa[i] + '">' + goa[i] + '</option>';
  }
  $('#pdistrict').html(optionss);
  });
  }
  
  if ($val=='Gujarat') {
    var gujarat = ["Ahmedabad","Amreli district","Anand","Aravalli","Banaskantha","Bharuch","Bhavnagar","Dahod","Dang","Gandhinagar","Jamnagar","Junagadh",
                                        "Kutch","Kheda","Mehsana","Narmada","Navsari","Patan","Panchmahal","Porbandar","Rajkot","Sabarkantha","Surendranagar","Surat","Tapi","Vadodara","Valsad"];
   $(function() {
  var optionss = '';
  for (var i = 0; i < gujarat.length; i++) {
      optionss += '<option value="' + gujarat[i] + '">' + gujarat[i] + '</option>';
  }
  $('#pdistrict').html(optionss);
  });
  }
  
  if ($val=='Haryana') {
    var haryana = ["Ambala","Bhiwani","Faridabad","Fatehabad","Gurgaon","Hissar","Jhajjar","Jind","Karnal","Kaithal",
                                            "Kurukshetra","Mahendragarh","Mewat","Palwal","Panchkula","Panipat","Rewari","Rohtak","Sirsa","Sonipat","Yamuna Nagar"];
   $(function() {
  var optionss = '';
  for (var i = 0; i < haryana.length; i++) {
      optionss += '<option value="' + haryana[i] + '">' + haryana[i] + '</option>';
  }
  $('#pdistrict').html(optionss);
  });
  }
  
  
  if ($val=='Himachal Pradesh') {
    var himachal = ["Baddi","Baitalpur","Chamba","Dharamsala","Hamirpur","Kangra","Kinnaur","Kullu","Lahaul & Spiti","Mandi","Simla","Sirmaur","Solan","Una"];
   $(function() {
  var optionss = '';
  for (var i = 0; i < himachal.length; i++) {
      optionss += '<option value="' + himachal[i] + '">' + himachal[i] + '</option>';
  }
  $('#pdistrict').html(optionss);
  });
  }
  
  if ($val=='Jammu and Kashmir') {
    var jammu = ["Jammu","Leh","Rajouri","Srinagar"];
   $(function() {
  var optionss = '';
  for (var i = 0; i < jammu.length; i++) {
      optionss += '<option value="' + jammu[i] + '">' + jammu[i] + '</option>';
  }
  $('#pdistrict').html(optionss);
  });
  }
  
  if ($val=='Jharkhand') {
    var jharkhand = ["Bokaro","Chatra","Deoghar","Dhanbad","Dumka","East Singhbhum","Garhwa","Giridih","Godda","Gumla","Hazaribag","Jamtara","Khunti","Koderma","Latehar","Lohardaga","Pakur","Palamu",
                                            "Ramgarh","Ranchi","Sahibganj","Seraikela Kharsawan","Simdega","West Singhbhum"];
   $(function() {
  var optionss = '';
  for (var i = 0; i < jharkhand.length; i++) {
      optionss += '<option value="' + jharkhand[i] + '">' + jharkhand[i] + '</option>';
  }
  $('#pdistrict').html(optionss);
  });
  }
  
  if ($val=='Karnataka') {
    var karnataka = ["Bagalkot","Bangalore","Bangalore Urban","Belgaum","Bellary","Bidar","Bijapur","Chamarajnagar", "Chikkamagaluru","Chikkaballapur",
                                           "Chitradurga","Davanagere","Dharwad","Dakshina Kannada","Gadag","Gulbarga","Hassan","Haveri district","Kodagu",
                                           "Kolar","Koppal","Mandya","Mysore","Raichur","Shimoga","Tumkur","Udupi","Uttara Kannada","Ramanagara","Yadgir"];
   $(function() {
  var optionss = '';
  for (var i = 0; i < karnataka.length; i++) {
      optionss += '<option value="' + karnataka[i] + '">' + karnataka[i] + '</option>';
  }
  $('#pdistrict').html(optionss);
  });
  }
  
  if ($val=='Kerala') {
    var kerala = ["Alappuzha","Ernakulam","Idukki","Kannur","Kasaragod","Kollam","Kottayam","Kozhikode","Malappuram","Palakkad","Pathanamthitta","Thrissur","Thiruvananthapuram","Wayanad"];
   $(function() {
  var optionss = '';
  for (var i = 0; i < kerala.length; i++) {
      optionss += '<option value="' + kerala[i] + '">' + kerala[i] + '</option>';
  }
  $('#pdistrict').html(optionss);
  });
  }
  
  if ($val=='Madhya Pradesh') {
    var mp = ["Alirajpur","Anuppur","Ashoknagar","Balaghat","Barwani","Betul","Bhilai","Bhind","Bhopal","Burhanpur","Chhatarpur","Chhindwara","Damoh","Dewas","Dhar","Guna","Gwalior","Hoshangabad",
                                    "Indore","Itarsi","Jabalpur","Khajuraho","Khandwa","Khargone","Malanpur","Malanpuri (Gwalior)","Mandla","Mandsaur","Morena","Narsinghpur","Neemuch","Panna","Pithampur","Raipur","Raisen","Ratlam",
                                    "Rewa","Sagar","Satna","Sehore","Seoni","Shahdol","Singrauli","Ujjain"];
   $(function() {
  var optionss = '';
  for (var i = 0; i < mp.length; i++) {
      optionss += '<option value="' + mp[i] + '">' + mp[i] + '</option>';
  }
  $('#pdistrict').html(optionss);
  });
  }
  
  if ($val=='Maharashtra') {
    var maharashtra = ["Ahmednagar","Akola","Alibag","Amaravati","Arnala","Aurangabad","Aurangabad","Bandra","Bassain","Belapur","Bhiwandi","Bhusaval","Borliai-Mandla","Chandrapur","Dahanu","Daulatabad","Dighi (Pune)","Dombivali","Goa","Jaitapur","Jalgaon",
                                             "Jawaharlal Nehru (Nhava Sheva)","Kalyan","Karanja","Kelwa","Khopoli","Kolhapur","Lonavale","Malegaon","Malwan","Manori",
                                             "Mira Bhayandar","Miraj","Mumbai (ex Bombay)","Murad","Nagapur","Nagpur","Nalasopara","Nanded","Nandgaon","Nasik","Navi Mumbai","Nhave","Osmanabad","Palghar",
                                             "Panvel","Pimpri","Pune","Ratnagiri","Sholapur","Shrirampur","Shriwardhan","Tarapur","Thana","Thane","Trombay","Varsova","Vengurla","Virar","Wada"];
   $(function() {
  var optionss = '';
  for (var i = 0; i < maharashtra.length; i++) {
      optionss += '<option value="' + maharashtra[i] + '">' + maharashtra[i] + '</option>';
  }
  $('#pdistrict').html(optionss);
  });
  }
  
   if ($val=='Manipur') {
    var manipur = ["Bishnupur","Churachandpur","Chandel","Imphal East","Senapati","Tamenglong","Thoubal","Ukhrul","Imphal West"];
   $(function() {
  var optionss = '';
  for (var i = 0; i < manipur.length; i++) {
      optionss += '<option value="' + manipur[i] + '">' + manipur[i] + '</option>';
  }
  $('#pdistrict').html(optionss);
  });
  }
  
   if ($val=='Meghalaya') {
    var meghalaya = ["Baghamara","Balet","Barsora","Bolanganj","Dalu","Dawki","Ghasuapara","Mahendraganj","Moreh","Ryngku","Shella Bazar","Shillong"];
   $(function() {
  var optionss = '';
  for (var i = 0; i < meghalaya.length; i++) {
      optionss += '<option value="' + meghalaya[i] + '">' + meghalaya[i] + '</option>';
  }
  $('#pdistrict').html(optionss);
  });
  }
  
   if ($val=='Mizoram') {
    var mizoram = ["Aizawl","Champhai","Kolasib","Lawngtlai","Lunglei","Mamit","Saiha","Serchhip"];
   $(function() {
  var optionss = '';
  for (var i = 0; i < mizoram.length; i++) {
      optionss += '<option value="' + mizoram[i] + '">' + mizoram[i] + '</option>';
  }
  $('#pdistrict').html(optionss);
  });
  }
  
   if ($val=='Nagaland') {
    var nagaland = ["Dimapur","Kiphire","Kohima","Longleng","Mokokchung","Mon","Peren","Phek","Tuensang","Wokha","Zunheboto"];
   $(function() {
  var optionss = '';
  for (var i = 0; i < nagaland.length; i++) {
      optionss += '<option value="' + nagaland[i] + '">' + nagaland[i] + '</option>';
  }
  $('#pdistrict').html(optionss);
  });
  }
  
  if ($val=='Orissa') {
    var orissa = ["Bahabal Pur","Bhubaneswar","Chandbali","Gopalpur","Jeypore","Paradip Garh","Puri","Rourkela"];
   $(function() {
  var optionss = '';
  for (var i = 0; i < orissa.length; i++) {
      optionss += '<option value="' + orissa[i] + '">' + orissa[i] + '</option>';
  }
  $('#pdistrict').html(optionss);
  });
  }
  
  if ($val=='Puducherry') {
    var puducherry = ["Karaikal","Mahe","Pondicherry","Yanam"];
   $(function() {
  var optionss = '';
  for (var i = 0; i < puducherry.length; i++) {
      optionss += '<option value="' + puducherry[i] + '">' + puducherry[i] + '</option>';
  }
  $('#pdistrict').html(optionss);
  });
  }
  
  if ($val=='Punjab') {
    var punjab = ["Amritsar","Barnala","Bathinda","Firozpur","Faridkot","Fatehgarh Sahib","Fazilka","Gurdaspur","Hoshiarpur","Jalandhar","Kapurthala","Ludhiana","Mansa","Moga","Sri Muktsar Sahib","Pathankot",
                                        "Patiala","Rupnagar","Ajitgarh (Mohali)","Sangrur","Shahid Bhagat Singh Nagar","Tarn Taran"];
   $(function() {
  var optionss = '';
  for (var i = 0; i < punjab.length; i++) {
      optionss += '<option value="' + punjab[i] + '">' + punjab[i] + '</option>';
  }
  $('#pdistrict').html(optionss);
  });
  }
  
  if ($val=='Rajasthan') {
    var rajasthan = ["Ajmer","Banswara","Barmer","Barmer Rail Station","Basni","Beawar","Bharatpur","Bhilwara","Bhiwadi","Bikaner","Bongaigaon","Boranada, Jodhpur","Chittaurgarh","Fazilka","Ganganagar","Jaipur","Jaipur-Kanakpura",
                                       "Jaipur-Sitapura","Jaisalmer","Jodhpur","Jodhpur-Bhagat Ki Kothi","Jodhpur-Thar","Kardhan","Kota","Munabao Rail Station","Nagaur","Rajsamand","Sawaimadhopur","Shahdol","Shimoga","Tonk","Udaipur"];
   $(function() {
  var optionss = '';
  for (var i = 0; i < rajasthan.length; i++) {
      optionss += '<option value="' + rajasthan[i] + '">' + rajasthan[i] + '</option>';
  }
  $('#pdistrict').html(optionss);
  });
  }
  
  if ($val=='Sikkim') {
    var sikkim = ["Chamurci","Gangtok"];
   $(function() {
  var optionss = '';
  for (var i = 0; i < sikkim.length; i++) {
      optionss += '<option value="' + sikkim[i] + '">' + sikkim[i] + '</option>';
  }
  $('#pdistrict').html(optionss);
  });
  }
  
  
  if ($val=='Tamil Nadu') {
    var tn = ["Ariyalur","Chennai","Coimbatore","Cuddalore","Dharmapuri","Dindigul","Erode","Kanchipuram","Kanyakumari","Karur","Krishnagiri","Madurai","Mandapam","Nagapattinam","Nilgiris","Namakkal","Perambalur","Pudukkottai","Ramanathapuram","Salem","Sivaganga","Thanjavur","Thiruvallur","Tirupur",
                                   "Tiruchirapalli","Theni","Tirunelveli","Thanjavur","Thoothukudi","Tiruvallur","Tiruvannamalai","Vellore","Villupuram","Viruthunagar"];
   $(function() {
  var optionss = '';
  for (var i = 0; i < tn.length; i++) {
      optionss += '<option value="' + tn[i] + '">' + tn[i] + '</option>';
  }
  $('#pdistrict').html(optionss);
  });
  }
  
  
  if ($val=='Telangana') {
    var telangana = ["Adilabad","Hyderabad","Karimnagar","Mahbubnagar","Medak","Nalgonda","Nizamabad","Ranga Reddy","Warangal"];
   $(function() {
  var optionss = '';
  for (var i = 0; i < telangana.length; i++) {
      optionss += '<option value="' + telangana[i] + '">' + telangana[i] + '</option>';
  }
  $('#pdistrict').html(optionss);
  });
  }
  
  
  if ($val=='Tripura') {
    var tripura = ["Agartala","Dhalaighat","Kailashahar","Kamalpur","Kanchanpur","Kel Sahar Subdivision","Khowai","Khowaighat","Mahurighat","Old Raghna Bazar","Sabroom","Srimantapur"];
   $(function() {
  var optionss = '';
  for (var i = 0; i < tripura.length; i++) {
      optionss += '<option value="' + tripura[i] + '">' + tripura[i] + '</option>';
  }
  $('#pdistrict').html(optionss);
  });
  }
  
  
  if ($val=='Uttar Pradesh') {
    var up = ["Agra","Allahabad","Auraiya","Banbasa","Ballia","Bareilly","Berhni","Bhadohi","Dadri","Dharchula","Gandhar","Gauriphanta","Ghaziabad","Gorakhpur","Gunji",
                                    "Jarwa","Jhulaghat (Pithoragarh)","Kanpur","Katarniyaghat","Khunwa","Loni","Lucknow","Meerut","Moradabad","Muzaffarnagar","Nepalgunj Road","Pakwara (Moradabad)",
                                    "Pantnagar","Saharanpur","Sonauli","Surajpur","Tikonia","Varanasi"];
   $(function() {
  var optionss = '';
  for (var i = 0; i < up.length; i++) {
      optionss += '<option value="' + up[i] + '">' + up[i] + '</option>';
  }
  $('#pdistrict').html(optionss);
  });
  }
  
  
  if ($val=='Uttarakhand') {
    var uttarakhand = ["Almora","Badrinath","Bangla","Barkot","Bazpur","Chamoli","Chopra","Dehra Dun","Dwarahat","Garhwal","Haldwani","Hardwar","Haridwar","Jamal","Jwalapur","Kalsi","Kashipur","Mall",
                                           "Mussoorie","Nahar","Naini","Pantnagar","Pauri","Pithoragarh","Rameshwar","Rishikesh","Rohni","Roorkee","Sama","Saur"];
   $(function() {
  var optionss = '';
  for (var i = 0; i < uttarakhand.length; i++) {
      optionss += '<option value="' + uttarakhand[i] + '">' + uttarakhand[i] + '</option>';
  }
  $('#pdistrict').html(optionss);
  });
  }
  
  
  if ($val=='West Bengal') {
    var wb = ["Alipurduar","Bankura","Bardhaman","Birbhum","Cooch Behar","Dakshin Dinajpur","Darjeeling","Hooghly","Howrah",
                                    "Jalpaiguri","Kolkata","Maldah","Murshidabad","Nadia","North 24 Parganas","Paschim Medinipur","Purba Medinipur","Purulia","South 24 Parganas","Uttar Dinajpur"];
   $(function() {
  var optionss = '';
  for (var i = 0; i < wb.length; i++) {
      optionss += '<option value="' + wb[i] + '">' + wb[i] + '</option>';
  }
  $('#pdistrict').html(optionss);
  });
  }
  
}
