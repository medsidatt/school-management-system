@extends('layouts.app')
@section('title', 'List des etudiants')

@section('content')
    <style>
        .report-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 20px;
        }

        .report-header img {
            width: 100px;
        }

        .report-title {
            font-size: 0.8rem;
            font-weight: bold;
        }

        .report-subtitle {
            font-size: 0.8rem;
        }

        .report-header {
            text-align: center;
            margin-bottom: 16px;
        }

        .report-header h1 {
            margin: 0;
        }

        .report-header h2 {
            margin: 5px 0 0 0;
            font-size: 1.2rem;
        }

        .report-info-1, .report-info-2 {
            display: flex;
            justify-content: space-between;
            border: 1px solid black;
            padding: 10px;
            border-radius: 10px;
        }

        .report-info-1 div, .report-info-2 div {
            flex: 1;
            text-align: left;
        }

        .report-info-1 div:last-child, .report-info-2 div:last-child {
            text-align: right;
        }

        .report-info-1 span, .report-info-2 span {
            display: block;
            text-align: left;
            margin-bottom: 5px;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .report-table th, .report-table td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        .report-table th {
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

    <div class="pagetitle">
        <h1 class="mb-1">List des note du 2<sup>em</sup> composition</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item">2<sup>em</sup> Composition</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->


    <div id="alert"></div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card w-auto">
                    <div class="card-body">
                        <div class="col"><p class="card-title">Tout les note du 2<sup>em</sup> composition</p></div>
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
                    <div class="report-header">
                        <div class="report-title">RÉPUBLIQUE ISLAMIQUE DE MAURITANIE</div>
                        <div class="report-subtitle">Honneur – Fraternité – Justice</div>
                        <div class="report-title">Ministère de l’Éducation Nationale et de la Réforme du Système
                            Educatif
                        </div>
                    </div>

                    <div class="report-card">
                        <div class="report-header">
                            <h2>Bulletin de notes de la composition N°2</h2>
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
            function reportContentGenerator(subjects, student) {
                return `
                        <div class="report-info-1">
                            <div>
                                <span>Nom : ${student.name}</span>
                                <span>Classe : ${student.class_name}</span>
                                <span>Matricule : Rim${student.rim}</span>
                            </div>
                        </div>
                        <table class="report-table">
                            <thead>
                                <tr>
                                    <th>Matieres</th>
                                    <th>Notes</th>
                                    <th>Coefficients</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${subjects.map(subject => `
                                    <tr>
                                        <td>${subject.name}</td>
                                        <td>${subject.note}</td>
                                        <td>${subject.coefficient}</td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                        <div class="report-info-2">
                            <div>
                                <span>Totale : ${parseFloat(subjects.reduce((acc, subject) => acc + (subject.coefficient * subject.note), 0)).toFixed(2)}</span>
                                <span>Moyenne Generale : ${parseFloat(subjects.reduce((acc, subject) => acc + (subject.coefficient * subject.note), 0) / subjects.reduce((acc, subject) => acc + subject.coefficient, 0)).toFixed(2)}</span>
                                <span>Sibnature et cachet du Directeur d'etablisement :</span>
                                <span>. . . . . . . . .</span>
                                <span>. . . . . . . . .</span>
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
                                <th>Matieres</th>
                                <th>Notes</th>
                                <th>Coefficients</th>
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
                        url: "{{ route('compositions.quarters.second.filtered', '') }}",
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
                                    url: "{{ route('compositions.quarters.second.filtered') }}",
                                    data: {class_id: classId},
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
                                        render: function (row) {
                                            return 'Rim' + row;
                                        },
                                    },
                                    {data: 'name'},
                                    {
                                        data: 'average',
                                        render: function (row) {
                                            return parseFloat(row).toFixed(2);
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
                    url: "{{ route('compositions.quarters.second.show') }}",
                    success: function (response) {
                        if (response.class && response.student) {
                            var reportContent = reportContentGenerator(response.class, response.student);
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
                    url: "{{ route('compositions.quarters.second.show') }}",

                    success: function (response) {
                        if (response.class && response.student) {
                            var printContents = reportContentGenerator(response.class, response.student);
                            var originalContents = document.body.innerHTML;

                            var printWindow = window.open('', '_blank');
                            printWindow.document.open();
                            printWindow.document.write(`<html>
                                          <head>
                                            <style>
                                                @page {margin: 0; size: auto;}

                                                body {
                                                    font-family: Arial, sans-serif;
                                                    margin: 10px;
                                                    padding: 0;
                                                }

                                                @media print {
                                                    table {
                                                        width: 90%;
                                                        margin: auto;
                                                    }

                                                }
                                                .header {
                                                    display: flex;
                                                    flex-direction: column;
                                                    align-items: center;
                                                    margin: 20px;
                                                }
                                                .header img {
                                                    width: 100px;
                                                }
                                                .title {
                                                    font-size: 0.8rem;
                                                    font-weight: bold;
                                                }
                                                .subtitle {
                                                    font-size: 0.8rem;
                                                }

                                                .header {
                                                    text-align: center;
                                                    margin-bottom: 16px;
                                                }
                                                .header h1 {
                                                    margin: 0;
                                                }
                                                .header h2 {
                                                    margin: 5px 0 0 0;
                                                    font-size: 1.2rem;
                                                }
                                                .report-info-1, .report-info-2 {
                                                    display: flex;
                                                    justify-content: space-between;
                                                    border: 1px solid black;
                                                    padding: 10px;
                                                    border-radius: 10px;
                                                }

                                                .report-info-1 div, .report-info-2 div {
                                                    flex: 1;
                                                    text-align: left;
                                                }

                                                .report-info-1 div:last-child, .report-info-2 div:last-child {
                                                    text-align: right;
                                                }

                                                .report-info-1 span, .report-info-2 span {
                                                    display: block;
                                                    text-align: left;
                                                    margin-bottom: 5px;
                                                }

                                              table {
                                                    width: 100%;
                                                    border-collapse: collapse;
                                                    margin: 20px 0;
                                                }
                                                th, td {
                                                    border: 1px solid black;
                                                    padding: 8px;
                                                    text-align: center;
                                                }
                                                th {
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
                                          <body>`);
                            printWindow.document.write(`<div class="header">
                                            <div class="title">RÉPUBLIQUE ISLAMIQUE DE MAURITANIE</div>
                                            <div class="subtitle">Honneur – Fraternité – Justice</div>
                                            <div class="title">Ministère de l’Éducation Nationale et de la Réforme du Système Educatif</div>
                                        </div>

                                        <div class="report-card">
                                          <div class="header">
                                              <h2>Bulletin de notes de la composition N°1</h2>
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
                                                @page {margin: 0; size: auto;}

                                                body {
                                                    font-family: Arial, sans-serif;
                                                    margin: 10px;
                                                    padding: 0;
                                                }

                                                @media print {
                                                    table {
                                                        width: 90%;
                                                        margin: auto;
                                                    }

                                                }
                                                .header {
                                                    display: flex;
                                                    flex-direction: column;
                                                    align-items: center;
                                                    margin: 20px;
                                                }
                                                .header img {
                                                    width: 100px;
                                                }
                                                .title {
                                                    font-size: 0.8rem;
                                                    font-weight: bold;
                                                }
                                                .subtitle {
                                                    font-size: 0.8rem;
                                                }

                                                .header {
                                                    text-align: center;
                                                    margin-bottom: 16px;
                                                }
                                                .header h1 {
                                                    margin: 0;
                                                }
                                                .header h2 {
                                                    margin: 5px 0 0 0;
                                                    font-size: 1.2rem;
                                                }
                                                .report-info-1, .report-info-2 {
                                                    display: flex;
                                                    justify-content: space-between;
                                                    border: 1px solid black;
                                                    padding: 10px;
                                                    border-radius: 10px;
                                                }

                                                .report-info-1 div, .report-info-2 div {
                                                    flex: 1;
                                                    text-align: left;
                                                }

                                                .report-info-1 div:last-child, .report-info-2 div:last-child {
                                                    text-align: right;
                                                }

                                                .report-info-1 span, .report-info-2 span {
                                                    display: block;
                                                    text-align: left;
                                                    margin-bottom: 5px;
                                                }

                                              table {
                                                    width: 100%;
                                                    border-collapse: collapse;
                                                    margin: 20px 0;
                                                }
                                                th, td {
                                                    border: 1px solid black;
                                                    padding: 8px;
                                                    text-align: center;
                                                }
                                                th {
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
                                          <body>`);
                printWindow.document.write(`<div class="header">
                                        <!-- <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/96/National_Seal_of_Mauritania.svg/240px-National_Seal_of_Mauritania.svg.png" alt="République Islamique de Mauritanie"> -->
                                            <div class="title">RÉPUBLIQUE ISLAMIQUE DE MAURITANIE</div>
                                            <div class="subtitle">Honneur – Fraternité – Justice</div>
                                            <div class="title">Ministère de l’Éducation Nationale et de la Réforme du Système Educatif</div>
                                        </div>

                                        <div class="report-card">
                                          <div class="header">
                                              <h2>Bulletin de notes de la composition N°1</h2>
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
                    url: "{{ route('compositions.quarters.second.resultsToPdf') }}",
                    data: { "classId": $('#class').val() },
                    success: function (response) {
                        const { jsPDF } = window.jspdf;
                        var doc = new jsPDF();


                        var startY = 20;
                        doc.setFontSize(13);
                        doc.text('RÉPUBLIQUE ISLAMIQUE DE MAURITANIE', 10, startY);
                        startY += 9;
                        doc.text('Honneur – Fraternité – Justice', 10, startY);
                        startY += 9;
                        doc.text('Ministère de l’Éducation Nationale et de la Réforme du Système Educatif', 10, startY);

                        startY += 9;
                        doc.text('Resultat du 2em composition', 10, startY);

                        $.each(response[0], function (index, student) {
                            var finalY = startY + 20;
                            var name = student.name;
                            var rim = student.rim;

                            // Add student name
                            doc.setFontSize(12);
                            doc.text('Nom: ' + name, 10, finalY);
                            finalY += 10;
                            doc.text('Matricule: Rim ' + rim.toString(), 10, finalY);

                            // Move position for the table
                            finalY += 10;

                            // Prepare data for the table
                            var examData = Object.values(student.notes).map(exam => [
                                exam.name,
                                exam.note.toString(),
                                exam.coefficient.toString()
                            ]);

                            // Add table
                            doc.autoTable({
                                startY: finalY,
                                head: [['Matiere', 'Note', 'Coefficient']],
                                body: examData,
                                theme: 'grid',
                                styles: { fontSize: 10, cellPadding: 3 },
                                headStyles: { fillColor: [108, 108, 108] },
                                margin: { left: 10, right: 10 },
                                columnStyles: {
                                    0: { cellWidth: 70 },
                                    1: { cellWidth: 40 },
                                    2: { cellWidth: 30 }
                                }
                            });

                            // Calculate finalY position for the average text
                            var tableFinalY = doc.autoTable.previous.finalY;

                            var total = 0;
                            var sumCoefficient = 0;

                            $.each(student.notes, function (index, exam) {
                                total += parseFloat(exam.note) * exam.coefficient;
                                sumCoefficient += exam.coefficient;
                            });

                            var average = sumCoefficient !== 0 ? (total / sumCoefficient).toFixed(2) : 0;

                            // Add total and average
                            doc.autoTable({
                                startY: tableFinalY,
                                body: [
                                    ['Totale', total.toFixed(2)],
                                    ['Moyenne générale', average]
                                ],
                                theme: 'grid',
                                styles: { fontSize: 10, cellPadding: 3 },
                                margin: { left: 10, right: 10 },
                                columnStyles: {
                                    0: { cellWidth: 110 },
                                    1: { cellWidth: 30 },
                                },
                                fontStyle: 'bold',
                            });

                            // Add line separator between students
                            tableFinalY = doc.autoTable.previous.finalY + 10;
                            doc.setLineWidth(0.5);
                            doc.line(10, tableFinalY, 200, tableFinalY);
                            startY = tableFinalY + 10;
                        });

                        doc.save('resultats.pdf');
                    }
                });
            }


        </script>

@endsection
