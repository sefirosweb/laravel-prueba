@extends('layout')

@section('body')
    <div class="row">
        <div class="col-lg-12">
            <h4>Poblaciones</h4>
            <div class="table-responsive">
                <div id="toolbar" class="form-inline">
                    <button type="button" class="btn btn-success mr-2" id="addButton">Add</button>
                </div>
                <table id="listTable" data-id-field="id" data-unique-id="id" data-toolbar="#toolbar" data-search="true"
                    data-show-toggle="false" data-url="{{ url('town/crud') }}">
                </table>
            </div>
        </div>
    </div>

    <!-- CRUD Modal -->
    <div class="modal fade" id="crudModal" tabindex="-1" role="dialog" data-backdrop="static"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Crud Modal</h5>
                </div>
                <div class="modal-body">
                    <form method="POST" id="crudForm">
                        <input type="hidden" name="id" id="id">
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <div class="form-group">
                            <label class="col-form-label">Poblacion:</label>
                            <input type="text" class="form-control" name="town_name">
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Cod. Postal Corto:</label>
                            <input type="text" class="form-control" name="short_postcode">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <fieldset class="w-100">
                        <button type="button" class="btn btn-success" id="acceptCrudButton">Save</button>
                        <button type="button" class="btn btn-secondary float-right" data-dismiss="modal">Close</button>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('javascript')

    <script>
        $(document).ready(function() {

            // Definition Area //
            const $listTable = $('#listTable') // BoostrapTable
            const $crudForm = $('#crudForm') // Form
            const $acceptCrudButton = $('#acceptCrudButton') // Accept Modal Button (Create / Delete)
            const $crudModal = $('#crudModal') // Modal
            const $id = $('#id') // ID for Update / Delete
            const $addButton = $('#addButton') // Show Moddal - Create
            const $editButton = '.editButton' // Show Modal - Edit
            const $deleteButton = '.deleteButton' // Show Alert - Delete
            let actionType

            $listTable.bootstrapTable({
                columns: [{
                    field: 'id',
                    title: 'id',
                    sortable: true,
                    align: 'center',
                    visible: true
                }, {
                    field: 'town_name',
                    title: 'Poblacion',
                    sortable: true,
                    align: 'center'
                }, {
                    field: 'short_postcode',
                    title: 'CP',
                    sortable: true,
                    align: 'center'
                }, {
                    field: 'created_at',
                    title: 'Created At',
                    sortable: true,
                    align: 'center'
                }, {
                    field: 'updated_at',
                    title: 'Updated At',
                    sortable: true,
                    align: 'center'
                }, {
                    field: '',
                    title: '',
                    sortable: false,
                    align: 'center',
                    width: '20px',
                    formatter: function($value, $row, $index) {
                        return `<a href="{{ url('province') }}/${$row['id']}" class="btn btn-primary" data-id="${$row['id']}">Provincias</a>`
                    }
                }, {
                    field: '',
                    title: '',
                    sortable: false,
                    align: 'center',
                    width: '20px',
                    formatter: function($value, $row, $index) {
                        return `<span class="btn btn-warning editButton" data-id="${$row['id']}">Edit</span>`
                    }
                }, {
                    field: '',
                    title: '',
                    sortable: false,
                    align: 'center',
                    width: '20px',
                    formatter: function($value, $row, $index) {
                        return `<span class="btn btn-danger deleteButton" data-id="${$row['id']}">Delete</span>`
                    }
                }]
            })

            function crudAjax() {
                const formData = getFormData($crudForm)
                lockModal($crudModal)

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{ url('town/crud') }}',
                    type: actionType,
                    dataType: 'json',
                    data: formData,
                    success: () => {
                        $crudModal.modal('hide')
                        $listTable.bootstrapTable('refresh')
                    },
                    error: (xhr, textStatus, errorThrown) => {
                        switch (xhr.status) {
                            case 422:
                                const responseText = JSON.parse(xhr.responseText)
                                const errors = responseText.message + "\n" + Object.entries(
                                    responseText
                                    .errors).reduce((text, inputError) => {
                                    text += inputError[1].join("\n") + "\n"
                                    return text
                                }, '')
                                alert(errors)
                                break;
                            default:
                                console.log(xhr)
                                alert('Error inesperado')
                                break;
                        }
                    },
                    complete: () => {
                        unLockModal($crudModal)
                    }
                })
            }

            function getFormData($form) {
                const values = {}
                $.each($form.serializeArray(), function(i, field) {
                    values[field.name] = field.value
                })
                return values
            }

            function loadForm($form, data) {
                $form.find('input').each(function() {
                    const name = $(this).attr('name')
                    const value = data[name]
                    if (value !== undefined) {
                        $(this).val(value)
                    }
                })
            }

            $addButton.click(function() {
                $id.val('');
                actionType = 'POST'
                $crudModal.modal('show')
            })

            $(document).on('click', $editButton, function() {
                var $input_id = $(this).data('id')
                var $dataRow = $listTable.bootstrapTable('getRowByUniqueId', $input_id)
                $id.val($input_id)
                actionType = 'PUT'
                loadForm($crudForm, $dataRow)
                $('#crudModal').modal('show')
            })

            $(document).on('click', $deleteButton, function() {
                var $input_id = $(this).data('id')
                var $dataRow = $listTable.bootstrapTable('getRowByUniqueId', $input_id)
                var r = confirm(`Confirm delete:\n ${$dataRow['name']}`)
                if (r == true) {
                    actionType = 'DELETE'
                    $id.val($input_id)
                    crudAjax()
                }
            })

            $acceptCrudButton.click(function() {
                crudAjax() // Accept Create / Delete
            })

            function lockModal($modal) {
                $modal.find('.btn, input, textarea').prop('disabled', true)
            }

            function unLockModal($modal) {
                $modal.find('.btn, input, textarea').prop('disabled', false)
            }

            $crudForm.on('keyup keypress', function(e) {
                var keyCode = e.keyCode || e.which
                if (keyCode === 13) {
                    e.preventDefault()
                    return false
                }
            })

            $crudModal.on('hidden.bs.modal', function() {
                $(this).find('form')[0].reset()
            })
        })

    </script>
@endsection
