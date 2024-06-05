@extends('layouts.app')
@section('title', 'List des etudiants')

@section('content')
    <style>
        .bodymszs {
            font-family: Arial, sans-serif;
            margin: 10px;
            padding: 0;
        }
        @page{size: auto; margin: 0;}
        .headermszs {
            display: contents;
            flex-direction: column;
            align-items: center;
            margin: 20px;
            text-align: center;
            margin-bottom: 20px;
        }
        .headermszs img {
            float: left;
            width: 80px; /* Adjust the size as needed */
            height: 80px;

        }
        .titlemszs {
            font-size: 20px;
            font-weight: bold;
        }
        .subtitlemszs {
            font-size: 16px;
        }


        .headermszs h1 {
            margin: 0;
        }
        .headermszs h2 {
            margin: 5px 0 0 0;
            font-size: 1.2em;
        }
        .info {
            display: flex;
            justify-content: space-between;
            border: 1px solid black;
            padding: 10px;
            border-radius: 10px;
        }
        .info div {
            flex: 1;
            text-align: left;
        }
        .info div:last-child {
            text-align: right;
        }
        .info span {
            display: block;
            text-align: left;
            margin-bottom: 5px;
        }

        .tablemszs {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .tablemszs th, .tablemszs td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        .tablemszs th {
            background-color: #f2f2f2;
        }
        .subject {
            text-align: left;
        }
        .total-row td {
            font-weight: bold;
            border: 1px solid black;
        }

        .modal-content {
            width: 900px;
            margin: auto;
        }
    </style>

    <div class="pagetitle">
        <h1 class="mb-1">List des note du 3<sup>em</sup> composition</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item">3<sup>em</sup> Composition</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->


    <div id="alert"></div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card w-auto">
                    <div class="card-body">
                        <div class="col"><p class="card-title">Tout les note du 3<sup>em</sup> composition</p></div>
                        {{--<button class="btn btn-primary" id="show-modal">Show modal</button>--}}
                        <div>
                            <select id="class" onchange="classFunc(event)" name="class_id" class="form-select">
                                <option value="">Classe ~</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <hr>
                        <div style="border: 1px solid black; padding: 3px">
                            <table id="exams" class="table table-striped display" style="width: 100%">
                                <thead>
                                <tr>
                                    <th>Matricule</th>
                                    <th>Nom</th>
                                    <th>Moyenne</th>
                                </tr>
                                </thead>
                            </table>
                        </div>


                        <!-- End Table with stripped rows -->

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Modal HTML -->
    <div id="myModal" class="modal fade modal-lg" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="headermszs">
                        <img
                            src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/96/National_Seal_of_Mauritania.svg/240px-National_Seal_of_Mauritania.svg.png"
                            alt="République Islamique de Mauritanie"
                        />
                        <div class="titlemszs">RÉPUBLIQUE ISLAMIQUE DE MAURITANIE</div>
                        <div class="subtitlemszs">Honneur – Fraternité – Justice</div>
                        <div class="titlemszs">
                            Ministère de l’Éducation Nationale et de la Réforme du Système Educatif
                        </div>
                    </div>


                    <div id="table-container"></div>
                    <div class="modal-footer">
                        <button id="print-button" type="button" class="btn btn-danger">Printer</button>
                        <button id="hide-modal" type="button" class="btn btn-secondary">Fermer</button>
                    </div>
                </div>
            </div>
        </div>


        <script>
            function reportContentGenerator(student) {
                var sumCoef = 0;
                var total = 0;
                $.each(student.notes, function (index, note) {
                    sumCoef += note.coefficient;
                    total += ((parseFloat(note.firstExam) + parseFloat(note.secondExam) + parseFloat(note.thirdExam)) / 3) * note.coefficient;
                });

                return `
                        <div class="report-card">
                              <div class="headermszs">
\                                <h2>Bulletin de notes de la composition N°3</h2>
                              </div>
                              <div class="info">
                                <div>
                                  <span>Nom : ${student.name}</span>
                                  <span>Classe : ${student.class_name}</span>
                                  <span>Matricule : Rim${student.rim}</span>
                                </div>
                              </div>
                            </div>

                        <table class="tablemszs">
                            <thead>
                                <tr>
                                    <th rowspan="2">Matières</th>
                                    <th>1° Compo. (x1)</th>
                                    <th>2° Compo. (x2)</th>
                                    <th>3° Compo. (x3)</th>
                                    <th rowspan="2">Moy.Devoirs(x3)</th>
                                    <th rowspan="2">Moy.Matière(x3)</th>
                                    <th rowspan="2">Coefficient</th>
                                    <th rowspan="2">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${Object.values(student.notes).map(subject => `
                                    <tr>
                                        <td class="subject">${subject.subject_name}</td>
                                        <td>${parseFloat(subject.firstExam).toFixed(2)}</td>
                                        <td>${(subject.secondExam * 2).toFixed(2)}</td>
                                        <td>${(subject.thirdExam * 3).toFixed(2)}</td>
                                        <td>${((parseFloat(subject.firstTest) + parseFloat(subject.secondTest) + parseFloat(subject.thirdTest))).toFixed(2)}</td>
                                        <td>${((parseFloat(subject.firstExam) + parseFloat(subject.secondExam) * 2 + parseFloat(subject.thirdExam) * 3
                                                                              + (parseFloat(subject .firstTest) + parseFloat(subject.secondTest)
                                                                              + parseFloat(subject.thirdTest)) / 3)).toFixed(2)}</td>
                                        <td>${subject.coefficient}</td>
                                        <td>${((parseFloat(subject.firstExam) + parseFloat(subject.secondExam) * 2 + parseFloat(subject.thirdExam) * 3
                                                                              + (parseFloat(subject .firstTest) + parseFloat(subject.secondTest)
                                                                              + parseFloat(subject.thirdTest)) / 3)).toFixed(2)}</td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                        <div class="info">
                          <div>
                            <span>Total : ${total.toFixed(2)}</span>
                            <span>Moyenne Generale Annulle : ${(total / sumCoef).toFixed(2)}</span>
                            <span>Sibnature et cachet du Directeur d'etablisement :</span>
                          </div>
                        </div>

                    `;
            }

            function generateTable(subjects, student) {
                var tableContent = `
                        <div class="report-info-1">

                        </div>
                        <table class="report-table ">
                            <thead>
                            <tr>
                                <th rowspan="2">Matières</th>
                                <th>1° Compo. (x1)</th>
                                <th>2° Compo. (x2)</th>
                                <th>3° Compo. (x3)</th>
                                <th rowspan="2">Moy.Devoirs(x3)</th>
                                <th rowspan="2">Moy.Matière(x3)</th>
                                <th rowspan="2">Coefficient</th>
                                <th rowspan="2">Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <div class="report-info-2"></div>
                    `;
                $('#table-container').html(tableContent);
                var total = 0;
                var coefficients = 0;
                $('#table-container .report-info-1').append(
                    `<div>
                          <span>Nom : ${student.name}</span>
                          <span>Classe : ${student.class_name}</span>
                          <span>Matricule : Rim${student.rim}</span>
                    </div>`
                );

                $.each(subjects, function (index, subject) {
                    coefficients += subject.coefficient;
                    total += subject.coefficient * subject.note;
                    $('#table-container tbody').append(`
                        <tr>
                          <td>${subject.name}</td>
                          <td>${subject.note}</td>
                          <td>${subject.coefficient}</td>
                        </tr>`
                    );
                });
                $('#table-container .report-info-2').append(`
                    <div>
                         <span >Totale : ${parseFloat(total).toFixed(2)}</span>
                         <span>Moyenne Generale : ${parseFloat(total / coefficients).toFixed(2)}</span>
                         <span>Sibnature et cachet du Directeur d'etablisement :</span>
                         <span>. . . . . . . . .</span>
                         <span>. . . . . . . . .</span>
                    </div>`
                );
            }

            function classFunc(event) {
                let classId = event.target.value;
                let table = $('#exams');

                if (classId === '' && $.fn.DataTable.isDataTable('#exams')) {

                    table.find('tbody')
                        .html('<tr><td colspan="5" class="dt-empty">Il faut selectioner une classe s\'il vous plait</td></tr>');
                } else {
                    $.ajax({
                        url: "{{ route('compositions.quarters.third.filtered', '') }}",
                        data: {class_id: classId},
                        method: 'GET',
                        success: function (response) {
                            if ($.fn.DataTable.isDataTable('#exams')) {
                                table.DataTable().destroy();
                            }
                            table.DataTable({
                                language: {
                                    info: 'Affichage de la page _PAGE_ sur _PAGES_',
                                    infoEmpty: 'Aucun enregistrement disponible',
                                    emptyTable: "Aucun enregistrement disponible",
                                    infoFiltered: '(filtré à partir de _MAX_ enregistrements totaux)',
                                    lengthMenu: 'Afficher les enregistrements _MENU_ par page',
                                    zeroRecords: 'Rien trouvé - désolé',
                                    searchPlaceholder: 'Recherche',
                                    search: 'Rechercher',
                                },
                                processing: true,
                                serverSide: true,
                                ajax: {
                                    url: "{{ route('compositions.quarters.third.filtered') }}",
                                    data: {classId: classId},
                                },
                                scrollY: 400,
                                layout: {
                                    topEnd: {
                                        buttons: [
                                            {
                                                text: 'Printer',
                                                action: resultsToPdf

                                            }
                                        ],
                                        search: {
                                            placeholder: 'Rechercher'
                                        },
                                    }
                                },
                                pagingType: 'simple_numbers',
                                columns: [
                                    {
                                        data: 'rim',
                                        render: function (data, type, row) {
                                            if (type === 'display') {
                                                return 'Rim' + data;
                                            }

                                            if (type === 'filter') {
                                                console.log($(data).val());
                                                return $(data).val();
                                            }
                                            return data;
                                            return data;
                                        },
                                    },
                                    {data: 'name'},
                                    {
                                        data: 'average',
                                        render: function (data, type, row) {
                                            return parseFloat(data).toFixed(2);
                                            // if (type === 'display') {
                                            // }
                                            // return data;
                                        },
                                        searchable: false
                                    },
                                    {data: 'action', orderable: false}
                                ]
                            });
                        }

                    });
                }


            }


            function showFunc(id, classId) {
                $.ajax({
                    data: {
                        "id": id,
                        "classId": classId
                    },
                    url: "{{ route('compositions.quarters.third.show') }}",
                    success: function (response) {
                        if (response.student) {
                            var reportContent = reportContentGenerator(response.student);
                            $('#table-container').html(reportContent);
                            $("#myModal").modal('show');
                        }
                    }
                });
            }

            function printFunc(id, classId) {
                $.ajax({
                    data: {
                        "id": id,
                        "classId": classId
                    },
                    url: "{{ route('compositions.quarters.third.show') }}",

                    success: function (response) {
                        if (response.student) {
                            var printContents = reportContentGenerator(response.student);
                            var originalContents = document.body.innerHTML;

                            var printWindow = window.open('', '_blank');
                            printWindow.document.open();
                            printWindow.document.write(`<html>
  <head>
    <style>
      .bodymszs {
        font-family: Arial, sans-serif;
        margin: 10px;
        padding: 0;
      }
      @page {
        size: auto;
        margin: 0;
      }
      .headermszs {
        display: contents;
        flex-direction: column;
        align-items: center;
        margin: 20px;
        text-align: center;
        margin-bottom: 20px;
      }
      .headermszs img {
        float: left;
        width: 80px; /* Adjust the size as needed */
        height: 80px;
      }
      .titlemszs {
        font-size: 20px;
        font-weight: bold;
      }
      .subtitlemszs {
        font-size: 16px;
      }

      .headermszs h1 {
        margin: 0;
      }
      .headermszs h2 {
        margin: 5px 0 5px 0;
        font-size: 1.2em;
      }
      .info {
        display: flex;
        justify-content: space-between;
        border: 1px solid black;
        padding: 10px;
        border-radius: 10px;
      }
      .info div {
        flex: 1;
        text-align: left;
      }
      .info div:last-child {
        text-align: right;
      }
      .info span {
        display: block;
        text-align: left;
        margin-bottom: 5px;
      }

      .tablemszs {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
      }
      .tablemszs th,
      td {
        border: 1px solid black;
        padding: 8px;
        text-align: center;
      }
      .tablemszs th {
        background-color: #f2f2f2;
      }
      .subject {
        text-align: left;
      }
      .total-row td {
        font-weight: bold;
        border: 1px solid black;
      }
    </style>
  </head>
  <body class="bodymszs">
    <div class="headermszs">
      <img
        src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/96/National_Seal_of_Mauritania.svg/240px-National_Seal_of_Mauritania.svg.png"
        alt="République Islamique de Mauritanie"
      />
      <div class="titlemszs">RÉPUBLIQUE ISLAMIQUE DE MAURITANIE</div>
      <div class="subtitlemszs">Honneur – Fraternité – Justice</div>
      <div class="titlemszs">
        Ministère de l’Éducation Nationale et de la Réforme du Système Educatif
      </div>
    </div>`);
                            printWindow.document.write(printContents);
                            printWindow.document.write('</body></html>');
                            printWindow.document.close();

                            printWindow.focus();
                            printWindow.print();

                            document.body.innerHTML = originalContents;
                        }
                    }
                });

            }

            $('#print-button').click(function () {
                var printContents = document.getElementById('table-container').innerHTML;
                var originalContents = document.body.innerHTML;

                var printWindow = window.open('', '_blank');
                printWindow.document.open();
                printWindow.document.write(`<html>
                                          <head>
                                            <style>
      .bodymszs {
        font-family: Arial, sans-serif;
        margin: 10px;
        padding: 0;
      }
      @page {
        size: auto;
        margin: 0;
      }
      .headermszs {
        display: contents;
        flex-direction: column;
        align-items: center;
        margin: 20px;
        text-align: center;
        margin-bottom: 20px;
      }
      .headermszs img {
        float: left;
        width: 80px; /* Adjust the size as needed */
        height: 80px;
      }
      .titlemszs {
        font-size: 20px;
        font-weight: bold;
      }
      .subtitlemszs {
        font-size: 16px;
      }

      .headermszs h1 {
        margin: 0;
      }
      .headermszs h2 {
        margin: 5px 0 0 0;
        font-size: 1.2em;
      }
      .info {
        display: flex;
        justify-content: space-between;
        border: 1px solid black;
        padding: 10px;
        border-radius: 10px;
      }
      .info div {
        flex: 1;
        text-align: left;
      }
      .info div:last-child {
        text-align: right;
      }
      .info span {
        display: block;
        text-align: left;
        margin-bottom: 5px;
      }

      .tablemszs {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
      }
      .tablemszs th,
      td {
        border: 1px solid black;
        padding: 8px;
        text-align: center;
      }
      .tablemszs th {
        background-color: #f2f2f2;
      }
      .subject {
        text-align: left;
      }
      .total-row td {
        font-weight: bold;
        border: 1px solid black;
      }
    </style>
   </head>
  <body class="bodymszs">
    <div class="headermszs">
      <img
        src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/96/National_Seal_of_Mauritania.svg/240px-National_Seal_of_Mauritania.svg.png"
        alt="République Islamique de Mauritanie"
      />
      <div class="titlemszs">RÉPUBLIQUE ISLAMIQUE DE MAURITANIE</div>
      <div class="subtitlemszs">Honneur – Fraternité – Justice</div>
      <div class="titlemszs">
        Ministère de l’Éducation Nationale et de la Réforme du Système Educatif
      </div>
    </div>`);
                printWindow.document.write(printContents);
                printWindow.document.write('</body></html>');
                printWindow.document.close();

                printWindow.focus();
                printWindow.print();

                document.body.innerHTML = originalContents;
            });


            $('#hide-modal').on('click', () => {
                $("#myModal").modal('hide');
            });


            function resultsToPdf() {
                $.ajax({
                    url: "{{ route('compositions.quarters.third.resultsToPdf') }}",
                    data: {"classId": $('#class').val()},
                    success: function (response) {
                        const {jsPDF} = window.jspdf;
                        var doc = new jsPDF();

                        var startY = 20;
                        doc.setFontSize(13);
                        doc.text('RÉPUBLIQUE ISLAMIQUE DE MAURITANIE', 10, startY);
                        startY += 9;
                        doc.text('Honneur – Fraternité – Justice', 10, startY);
                        startY += 9;
                        doc.text('Ministère de l’Éducation Nationale et de la Réforme du Système Educatif', 10, startY);

                        startY += 9;
                        doc.text('Resultat du 3em composition', 10, startY);

                        $.each(response.result, function (index, student) {

                            var finalY = startY + 20;
                            var name = student.name;
                            var rim = student.rim;

                            doc.setFontSize(12);
                            doc.text('Nom: ' + name, 10, finalY);
                            finalY += 10;
                            doc.text('Matricule: Rim ' + rim.toString(), 10, finalY);

                            finalY += 10;


                            var examData = Object.values(student.notes).map(note => [
                                note.subject_name,
                                note.firstExam.toString(),
                                (note.secondExam * 2).toFixed(2).toString(),
                                (note.thirdExam * 3).toFixed(2).toString(),
                                (
                                    (parseFloat(note.firstTest) || 0) +
                                    (parseFloat(note.secondTest) || 0) +
                                    (parseFloat(note.thirdTest) || 0)
                                    / 3).toFixed(2).toString(),
                                note.secondTest.toString(),
                                note.coefficient.toString(),
                                note.thirdTest.toString()
                            ]);

                            doc.autoTable({
                                startY: finalY,
                                head: [['Matiere', '1 Compo (X1)', '2 Compo (X2)', '3 Compo (X3)', 'Moy. Interog', 'Moy. Dicipl', 'Coeff.', 'Totale']],
                                body: examData,
                                theme: 'grid',
                                styles: {fontSize: 10, cellPadding: 3},
                                headStyles: {fillColor: [108, 108, 108]},
                                margin: {left: 10, right: 10},
                                columnStyles: {
                                    0: {cellWidth: 50},
                                    1: {cellWidth: 20},
                                    2: {cellWidth: 20},
                                    3: {cellWidth: 20},
                                    4: {cellWidth: 20},
                                    5: {cellWidth: 20},
                                    6: {cellWidth: 20},
                                    7: {cellWidth: 20}
                                }
                            });


                            // // Calculate finalY position for the average text
                            var tableFinalY = doc.autoTable.previous.finalY;
                            //
                            // var total = 0;
                            // var sumCoefficient = 0;
                            //
                            // $.each(student.student.exams, function (index, exam) {
                            //     total += parseFloat(exam.note) * exam.coefficient;
                            //     sumCoefficient += exam.coefficient;
                            // });
                            //
                            // var average = sumCoefficient !== 0 ? (total / sumCoefficient).toFixed(2) : 0;
                            //
                            // // Add total and average
                            // doc.autoTable({
                            //     startY: tableFinalY,
                            //     body: [
                            //         ['Totale', total.toFixed(2)],
                            //         ['Moyenne générale', average]
                            //     ],
                            //     theme: 'grid',
                            //     styles: { fontSize: 10, cellPadding: 3 },
                            //     margin: { left: 10, right: 10 },
                            //     columnStyles: {
                            //         0: { cellWidth: 110 },
                            //         1: { cellWidth: 30 },
                            //     },
                            //     fontStyle: 'bold',
                            // });
                            //
                            // // Add line separator between students
                            // tableFinalY = doc.autoTable.previous.finalY + 10;
                            // doc.setLineWidth(0.5);
                            // doc.line(10, tableFinalY, 200, tableFinalY);
                            startY = tableFinalY + 10;
                        });

                        doc.save('resultats.pdf');
                    }
                });
            }


        </script>

@endsection
