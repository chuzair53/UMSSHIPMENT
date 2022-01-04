@component('mail::message')
# Introduction

The body of your message.

@component('mail::button', ['url' => ''])
Track Shipment
@endcomponent

@component('mail::table')
| Name          | Qty           | Price    |
| ------------- |:-------------:| --------:|
| Col 2 is      | Centered      | $10      |
| Col 3 is      | Right-Aligned | $20      |
@endcomponent
<h2>Address: Lorem ipsum, dolor sit amet consectetur adipisicing elit. Odio quae autem nostrum non nemo. Provident accusamus blanditiis accusantium, quod odit voluptas aperiam illum incidunt tempore quas animi porro autem soluta.</h2>
Thanks,<br>
{{ config('app.name') }}
@endcomponent
