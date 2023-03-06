<x-layout>
    <section class="single-block-wrapper section-padding">
        <x-sectionTitle title="Proposals" desc="Develop Web Application"></x-sectionTitle>
        <div class="row m-5 mt-0">
            <div class="card">
                <div class="card-body mt-0 pt-0">
                    <div class="active-member">
                        <div class="table-responsive">
                            <table class="table table-xs mb-0">
                                <thead>
                                    <tr>
                                        <th>Freelancer</th>
                                        <th>Bid</th>
                                        <th>Expected Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($proposals as $proposal )
                                    <tr>
                                        <td>{{ $proposal->user->name }}</td>
                                        <td>{{ $proposal->bid }}</td>
                                        <td>{{ $proposal->expected_by }}</td>
                                        <td>
                                            <x-tagMenu>
                                                <x-tag title="{{$proposal->status}}"></x-tag>
                                            </x-tagMenu>
                                            
                                        </td>
                                        <td class="">
                                            <form action="/proposals" method="POST">
                                                @csrf
                                                {{ method_field('PUT') }}
                                                <button class="btn btn-primary px-2 py-1" type="submit" name="status" id="submit_contact" value="view">View</button>
      
                                                <button
                                                @if ($proposal->status == 'Accepted' || $proposal->status == 'Rejected')
                                                    hidden
                                                @endif
                                                class="btn btn-primary px-2 py-1" type="submit" name="status" id="submit_contact" value="Accepted">Accept</button>
                                                <button
                                                @if ($proposal->status == 'Accepted' || $proposal->status == 'Rejected')
                                                    hidden
                                                @endif
                                                class="btn btn-primary px-2 py-1" type="submit" name="status" id="submit_contact" value="Rejected">Reject</button>
                                                <input hidden type="number" name="id" value="{{ $proposal->id }}">
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
</x-layout>