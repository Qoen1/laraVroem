<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 d-flex justify-content-center">
                    <h1 class="display-1">Refuel on {{$refuel->created_at->format('d-m-Y')}}</h1>

                </div>
                @if(session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                    <br>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger ">
                        {{ $errors->all()[0] }}
                    </div>
                    <br>
                @endif
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div>
                        <div class="row justify-content-start">
                            <div class="col">driven kilometers:</div>
                            <div class="col">{{$refuel->distance()}}</div>
                        </div>
                        <div class="row justify-content-start">
                            <div class="col">liters tanked:</div>
                            <div class="col">{{round($refuel->liters, 2)}} L</div>
                        </div>
                        <div class="row justify-content-start">
                            <div class="col">payed amount:</div>
                            <div class="col">€ {{round($refuel->cost, 2)}}</div>
                        </div>
                        <div class="row justify-content-start">
                            <div class="col">driver:</div>
                            <div class="col">{{ $refuel->user->name }}</div>
                        </div>
                    </div>
                    <hr class="mt-4 mb-4">
                    <div class="accordion">
                        @foreach($users as $user)
                            @if(auth()->user()->id === $user->id)
                                <div class="accordion-item">
                                    <div class="accordion-header text-decoration-none  text-black" id="{{$user->id}}">
                                        <button class="btn button accordion-button" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapse{{$user->id}}"
                                                aria-controls="collapse{{$user->id}}">
                                            {{$user->name}}
                                        </button>
                                    </div>
                                    <div id="collapse{{$user->id}}" class="accordion-collapse collapse show"
                                         aria-labelledby="Antwoord {{$user->id}}" data-bs-parent="#accordion">
                                        <div class="accordion-body">
                                            <div class="row justify-content-start">
                                                <div class="col">driven kilometers:</div>
                                                <div class="col">{{$refuel->userDriven($user)}}</div>
                                            </div>
                                            <div class="row justify-content-start">
                                                <div class="col">percentage driven:</div>
                                                <div class="col">{{round($refuel->percentageDriven($user))}}%</div>
                                            </div>
                                            <div class="row justify-content-start">
                                                <div class="col">amount owed:</div>
                                                <div class="col">€ {{round($refuel->amountToPay($user), 2)}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="accordion-item">
                                    <div class="accordion-header text-decoration-none  text-black" id="{{$user->id}}">
                                        <button class="btn button accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapse{{$user->id}}"
                                                aria-controls="collapse{{$user->id}}">
                                            {{$user->name}}
                                        </button>
                                    </div>
                                    <div id="collapse{{$user->id}}" class="accordion-collapse collapse"
                                         aria-labelledby="Antwoord {{$user->id}}" data-bs-parent="#accordion">
                                        <div class="accordion-body">
                                            <div class="row justify-content-start">
                                                <div class="col">driven kilometers:</div>
                                                <div class="col">{{$refuel->userDriven($user)}}</div>
                                            </div>
                                            <div class="row justify-content-start">
                                                <div class="col">percentage driven:</div>
                                                <div class="col">{{round($refuel->percentageDriven($user))}}%</div>
                                            </div>
                                            <div class="row justify-content-start">
                                                <div class="col">amount owed:</div>
                                                <div class="col">€ {{round($refuel->amountToPay($user), 2)}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="table">
                        <thead>
                        <th>created at</th>
                        <th>begin odometer</th>
                        <th>end odometer</th>
                        <th>distance</th>
                        <th>car</th>
                        <th>driver</th>
                        <th></th>
                        </thead>
                        @foreach($drives as $drive)
                            <tr>
                                <td>{{ $drive->created_at->format('d-m-Y') }}</td>
                                <td>{{ $drive->begin_odometer }}</td>
                                <td>{{ $drive->end_odometer }}</td>
                                <td>{{ $drive->distance() }}</td>
                                <td>{{ $drive->car->name }}</td>
                                <td>{{ $drive->user->name }}</td>
                                <td>
                                    <form action="/refuels/removeDrive" method="post">
                                        @csrf
                                        <input type="hidden" name="refuel_id" value="{{ $refuel->id }}">
                                        <input type="hidden" name="drive_id" value="{{ $drive->id }}">
                                        <button class="btn btn-danger bg-danger" type="submit">-</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
