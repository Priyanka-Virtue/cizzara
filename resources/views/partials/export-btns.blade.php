<div class="d-flex">
                    <div class="form-group">
                        <form id="exportForm" method="POST" action="{{ $exportAction ?? route('export.toppers') }}">
                            @csrf
                            <button id="exportButton" class="btn btn-outline-primary waves-effect" type="button"><i class="mdi mdi-microsoft-excel mdi-20px mr-1"></i> Export selected</button>
                        </form>
                    </div>
                    <div class="form-group px-2">
                        <button id="selectAllPages" class="btn btn-outline-primary waves-effect" type="button"><i class="mdi mdi-microsoft-excel mdi-20px mr-1"></i>Export All pages records</button>
                    </div>
                </div>
