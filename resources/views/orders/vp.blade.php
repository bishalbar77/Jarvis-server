<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <title>Search Results</title>
  <style type="text/css">
    table {
  text-align: left;
  position: relative;
  border-collapse: collapse; 
}
th {
  background: white;
  position: sticky;
  top: 200;
  z-index: 999999999999999999999999999999999999;
}
    tr {
      /*cursor: pointer !important;*/
    }
    a {
      display: block;
    }
  </style>
  <style>
.content {
  padding: 16px;
}

.sticky {
  position: fixed;
  top: 0;
  width: 100%;
}

.sticky + .content {
  padding-top: 102px;
}

.table-bordered th, .table-bordered td {
    border: 1px solid #9c9c9c !important;
}
a.anchor {
    color: #0010e6 !important;
     text-decoration: none; 
     background-color: transparent; 
}
div#myHeader {
  background: #4caddecc;
  padding: 0px 10px;
  color: #fff !important;
} 
.card-body {
    padding: 3px 17px;
}
  .table td, .table th {
    padding: 2px;
    vertical-align: middle;
}
</style>
</head>
<body>

<!-- users list start -->
<section class="users-list-wrapper containt-fluid">

  <!-- users filter start -->
  <div class="card header" id="myHeader" style="z-index: 99999999999;">
    <div class="card-content collapse show">
      <div class="card-body">
        <div class="users-list-filter">
          <div class="row">
            <div class="col-sm-2">
              <label style="font-size: 16px;" for="name">Candidate Name<br>{{ $employees->first_name }} {{ $employees->middle_name }} {{ $employees->last_name }}</label>
            </div>

            <div class="col-sm-2">
              <label style="font-size: 16px;" for="father_name">Father Name<br>{{ $employees->co_name }}</label>
            </div>

            <div class="col-sm-8">
              <label style="font-size: 16px;" for="address">Address<br>
                @if(isset($addresses))
                  {{ $addresses->street_addr1 }} 
                  {{ $addresses->street_addr2 }} 
                  {{ $addresses->village }}
                  {{ $addresses->post_office }}
                  {{ $addresses->police_station }}
                  {{ $addresses->district }}
                  {{ $addresses->near_by }}
                  {{ $addresses->city }}
                  {{ $addresses->state }}
                  {{ $addresses->pincode }}
                @endif
              </label>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- users filter end -->
  @if(isset($vpdata) && !empty($vpdata))
  <!-- Ag Grid users list section start -->
  <div id="basic-examples">
    <div class="card">
      <div class="card-content">
        <div class="card-body">
          <!-- Hoverable rows start -->
          <div class="row" id="table-hover-row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="table-responsive" style="overflow-x:auto;">
                            <table class="table table-hover mb-0 table-bordered" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th style="width: 1% !important; text-align: center;">Si No.</th>
                                  <th style="width: 150px !important; text-align: center;">Matched Name</th>
                                  <th style="width: 450px !important; text-align: center;">Matched Address</th>
                                  <th>Dist. Name</th>
                                  <th>State Name</th>
                                  <th>Case Category</th>
                                  <th>Petitoner/Respondant</th>
                                  <th>Court Name</th>
                                  <th>Ecourt Link</th>
                                  <th>Case Type</th>
                                  <th>FIR No.</th>
                                  <th>PS Name</th>
                                  <th>Act Name</th>
                                  <th>Under Section</th>
                                  <th>Score %</th>
                                </tr>
                              </thead>
                                                                
                              <tbody>
                                @foreach($vpdata as $key => $case)
                                  <tr>
                                    <td style="text-align: center;">{{ $key + 1 }}</td>
                                    <td>{{ $case->name ?? '' }}</td>
                                    <td>{{ $case->address ?? '' }}</td>
                                    <td>{{ $case->address_district ?? '' }}</td>
                                    <td>{{ $case->state_name ?? '' }}</td>
                                    <td>{{ $case->case_category ?? '' }}</td>
                                    <td>{{ $case->type == 0 ? 'Petitioner' : 'Respondent' }}</td>
                                    <td>{{ $case->court_name ?? '' }}</td>
                                    <td><a class="anchor" href="{{ $case->link ?? '' }}" target="_blank"> View </a></td>
                                    <td>{{ $case->case_type ?? '' }}</td>
                                    <td>{{ $case->fir_no ?? '' }}</td>
                                    <td>{{ $case->police_station ?? '' }}</td>
                                    <td>{{ $case->under_acts ?? '' }}</td>
                                    <td>{{ $case->under_sections ?? '' }}</td>
                                    <td>{{ $case->score ?? '' }}</td>
                                  </tr>
                                @endforeach
                              </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
          </div>
          <!-- Hoverable rows end -->
        </div>
      </div>
    </div>
  </div>
  <!-- Ag Grid users list section end -->
  @endif
</section>
    <!-- users list ends -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
      window.onscroll = function() {
        myFunction();
      }

      var header = document.getElementById("myHeader");
      var sticky = header.offsetTop;

      function myFunction() {
        if (window.pageYOffset > sticky) {
          header.classList.add("sticky");
        } else {
          header.classList.remove("sticky");
        }
      }
    </script>
  </body>
</html>