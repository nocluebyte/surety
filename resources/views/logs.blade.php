{{-- Extends layout --}}
@extends('app')
{{-- Content --}}
@section('content')

@section('title', __('common.logs'))

@component('partials._subheader.subheader-v6',
    [
        'page_title' => __('common.logs'),
        'permission' => $current_user->hasAnyAccess(['users.superadmin']),
    ])
    ,
@endcomponent

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        @include('components.error')
        <div class="row">
            <div class="col-lg-12 pt-5">
                <div class="card card-custom">
                    <div class="card-body">
                        <!--begin::Example-->
                        <div class="example example-basic">
                            <div class="example-preview">
                                <div class="timeline timeline-justified timeline-4">
                                    <div class="timeline-bar"></div>
                                    <div class="timeline-items" id="post_data"></div>
                                </div>
                            </div>
                        </div>
                        <!--end::Example-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        load_data('');
        function load_data(id="")
        {
            var dataKey = '{{ request()->get('key') }}';
            var revisionable_id = '{{ request()->get('revisionable_id') }}';
            $.ajax({
            url:"{{ route('loadmore.logs') }}",
            method:"POST",
            data:{id:id, 'key':dataKey, 'revisionable_id':revisionable_id},
            success:function(data)
            {
                $('#load_more_button').remove();
                $('#post_data').append(data);
            }
            });
        }

        $(document).on('click', '#load_more_button', function(){
            var id = $(this).data('id');
            $('#load_more_button').html('<b>Loading...</b>');
            load_data(id);
        });

    });
</script>
@endsection