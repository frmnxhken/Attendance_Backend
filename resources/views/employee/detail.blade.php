<x-layout>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item d-flex align-items-center">
                            <img style="margin-right: 15px; width: 80px; height: 80px; object-fit: cover;" class="rounded img-thumbnail img-fluid" src="https://upload.wikimedia.org/wikipedia/commons/0/08/Aespa_Karina_2024_MMA_2.jpg" />
                            <h4 class="text-dark">{{ $user->name }}</h4>
                        </li>
                        <li class="list-group-item">
                            {{ $user->nip }}
                        </li>
                        <li class="list-group-item">
                            {{ $user->email }}
                        </li>
                        <li class="list-group-item">
                            {{ $user->gender }}
                        </li>
                        <li class="list-group-item">
                            {{ $user->address }}
                        </li>
                        <li class="list-group-item">
                            {{ $user->office->name }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body overflow-hidden position-relative">
                            <iconify-icon icon="solar:leaf-bold-duotone" class="fs-2 text-primary"></iconify-icon>
                            <h3 class="mb-0 fw-bold mt-3 mb-1">{{ $statistic['present'] }}</h3>
                            <p class="text-muted">Total Present</p>
                            <i class="ri-survey-line widget-icon"></i>
                        </div> 
                    </div> 
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body overflow-hidden position-relative">
                            <iconify-icon icon="solar:flame-bold-duotone" class="fs-2 text-warning"></iconify-icon>    
                            <h3 class="mb-0 fw-bold mt-3 mb-1">{{ $statistic['late'] }}</h3>
                            <p class="text-muted">Total Late</p>
                            <i class="ri-arrow-right-down-line widget-icon"></i>
                        </div> 
                    </div> 
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body overflow-hidden position-relative">
                            <iconify-icon icon="solar:bookmark-circle-bold-duotone" class="fs-2 text-success"></iconify-icon>    
                            <h3 class="mb-0 fw-bold mt-3 mb-1">{{ $statistic['excused'] }}</h3>
                            <p class="text-muted">Total Excused</p>
                            <i class="ri-mail-open-line widget-icon"></i>
                        </div> 
                    </div> 
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body overflow-hidden position-relative">
                            <iconify-icon icon="solar:ghost-line-duotone" class="fs-2 text-danger"></iconify-icon>    
                            <h3 class="mb-0 fw-bold mt-3 mb-1">{{ $statistic['absent'] }}</h3>
                            <p class="text-muted">Total Absent</p>
                            <i class="ri-time-line widget-icon"></i>
                        </div> 
                    </div> 
                </div>
            </div>
        </div>
    </div>
</x-layout>