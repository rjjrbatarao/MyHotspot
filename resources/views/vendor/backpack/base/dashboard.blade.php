@extends(backpack_view('blank'))

@php
    /*$widgets['before_content'][] = [
        'type'        => 'jumbotron',
        'heading'     => trans('backpack::base.welcome'),
        'content'     => trans('backpack::base.use_sidebar'),
        'button_link' => backpack_url('logout'),
        'button_text' => trans('backpack::base.logout'),
    ];*/
    $widgets['before_content'][] = [
        'type'        => 'div',
        'class'     => 'row',
        'content'     => [
            [
                'type'          => 'progress',
                'class'         => 'card text-white border-0 bg-info',
                'value'         => '11.456',
                'description'   => 'Connected users.',
                'progress'      => 57, // integer
                'hint'          => '8544 more until next milestone.',                
            ],
            [
                'type'          => 'progress',
                'class'         => 'card text-white border-0 bg-warning',
                'value'         => '11.456',
                'description'   => 'Total sales.',
                'progress'      => 80, // integer
                'hint'          => '8544 more until next milestone.',                
            ],
            [
                'type'          => 'progress',
                'class'         => 'card text-white border-0 bg-success',
                'value'         => '11.456',
                'description'   => 'Bandwidth utilization.',
                'progress'      => 60, // integer
                'hint'          => '8544 more until next milestone.',                
            ],
            [
                'type'          => 'progress',
                'class'         => 'card text-white border-0 bg-danger',
                'value'         => '11.456',
                'description'   => 'Registered users.',
                'progress'      => 10, // integer
                'hint'          => '8544 more until next milestone.',                
            ]            
        ],
    ];
    
    $widgets['before_content'][] = [
                'type'          => 'system',
                'class'         => 'alert border border-secondary rounded mb-2 pt-4 col-lg-6',
                'progress1' => true,
                'progress2' => true,
                'progress3' => true,
    ];

    
    $widgets['before_content'][] = [
                'type'          => 'vnstat',
                'class'         => ' border border-secondary rounded mb-2 mt-4 pt-4',
                'content'       => 'Hourly traffic amount'
    ];    

@endphp

@section('content')
@endsection