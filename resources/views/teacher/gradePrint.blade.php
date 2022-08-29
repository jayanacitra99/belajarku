<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Student Grade - Assignment ('{{$ass->title}}')</title>
  <style>
    #grade {
      font-family: Arial, Helvetica, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }
    
    #grade td, #grade th {
      border: 1px solid #ddd;
      padding: 8px;
    }
    
    #grade tr:nth-child(even){background-color: #f2f2f2;}
    
    #grade tr:hover {background-color: #ddd;}
    
    #grade th {
      padding-top: 12px;
      padding-bottom: 12px;
      text-align: left;
      background-color: #04AA6D;
      color: white;
    }
    </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="card">
            <div class="card-header">
            <h2 class="card-title" style="text-align: center">Assignment : {{$ass->title}}</h2>
            <h5 style="text-align: center">{{$date}}</h5>
            <!-- /.card-header -->
            <div class="card-body p-0">
            <table class="table" id="grade">
                <thead>
                    <tr>
                        <th style="width: 10px">No. </th>
                        <th>Student Name</th>
                        <th>Class</th>
                        <th>Course</th>
                        <th>Grade</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1?>
                    @foreach ($cMember as $cm)
                    <tr>
                        <td>{{$no++}}</td>
                        <td>{{$cm->name}}</td>                        
                        <td>{{$class->class}}.{{$class->indexClass}}</td>
                        <td>{{$course->courseName}}</td>
                        <?php
                            $grade = 0;
                            foreach ($assLog as $log) {
                                if ($log->studentID == $cm->studentID) {
                                    $grade = $log->grade;
                                }
                            }    
                        ?>
                        <td style="{{$grade < 75 ? 'color:red':''}}">
                            {{$grade}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            <!-- /.card-body -->
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->
</body>
</html>
