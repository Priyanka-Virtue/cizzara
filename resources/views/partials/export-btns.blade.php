<div class="d-flex">
                    <div class="form-group">
                        <form id="exportForm" method="POST" action="{{ route('export.records') }}">
                            @csrf
                            <button id="exportButton" class="btn btn-primary waves-effect" type="button">Export selected</button>
                        </form>
                    </div>
                    <div class="form-group px-2">
                        <button id="selectAllPages" class="btn btn-primary waves-effect" type="button">Export All pages records</button>
                    </div>
                </div>
