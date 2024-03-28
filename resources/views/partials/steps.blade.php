<style>
    /*---------signup-step-------------*/


    .signup-step-container {
        padding: 150px 0px;
        padding-bottom: 60px;
    }




    .wizard .nav-tabsxxx {
        position: relative;
        margin-bottom: 0;
        border-bottom-color: transparent;
    }

    .wizard>div.wizard-inner {
        position: relative;
        margin-bottom: 50px;
        text-align: center;
    }

    .connecting-line {
        height: 2px;
        background: #e0e0e0;
        position: absolute;
        width: 80%;
        margin: 0 auto;
        left: 0;
        right: 0;
        top: 15px;
        z-index: 1;
    }

    .wizard .nav-tabsxxx>li.active>a,
    .wizard .nav-tabsxxx>li.active>a:hover,
    .wizard .nav-tabsxxx>li.active>a:focus {
        color: #555555;
        cursor: default;
        border: 0;
        border-bottom-color: transparent;
    }

    span.round-tab {
        width: 30px;
        height: 30px;
        line-height: 30px;
        display: inline-block;
        border-radius: 50%;
        background: #fff;
        z-index: 2;
        position: absolute;
        left: 0;
        text-align: center;
        font-size: 16px;
        color: #0e214b;
        font-weight: 500;
        border: 1px solid #ddd;
    }

    span.round-tab i {
        color: #555555;
    }

    .wizard li.active span.round-tab {
        background: #9c6868;
        color: #fff;
        border-color: #9c6868;
    }

    .wizard li.active span.round-tab i {
        color: #5bc0de;
    }

    .wizard .nav-tabsxxx>li.active>a i {
        color: #9c6868;
    }

    .wizard .nav-tabsxxx>li {
        width: 20%;
    }

    .wizard li:after {
        content: " ";
        position: absolute;
        left: 46%;
        opacity: 0;
        margin: 0 auto;
        bottom: 0px;
        border: 5px solid transparent;
        border-bottom-color: red;
        transition: 0.1s ease-in-out;
    }



    .wizard .nav-tabsxxx>li a {
        width: 30px;
        height: 30px;
        margin: 20px auto;
        border-radius: 100%;
        padding: 0;
        background-color: transparent;
        position: relative;
        top: 0;
    }

    .wizard .nav-tabsxxx>li a i {
        position: absolute;
        top: -15px;
        font-style: normal;
        font-weight: 400;
        white-space: nowrap;
        left: 50%;
        transform: translate(-24%, -50%);
        font-size: 12px;
        font-weight: 700;
        color: #fff;
    }

    .wizard .nav-tabsxxx>li a:hover {
        background: transparent;
    }

    .wizard .tab-pane {
        position: relative;
        padding-top: 20px;
    }


    .wizard h3 {
        margin-top: 0;
    }

    @media (max-width: 767px) {
        .sign-content h3 {
            font-size: 40px;
        }

        .wizard .nav-tabsxxx>li a i {
            display: none;
        }

    }

    .wizard .nav-tabsxxx>li.disabled>a,
    .wizard .nav-tabsxxx>li.disabled>a:hover,
    .wizard .nav-tabsxxx>li.disabled>a:focus {

        cursor: default;

    }

    ul.nav.nav-tabsxxx {
        min-height: 100px;
    }

    .wizard .nav-tabsxxx>li a i {
        top: 55px
    }

    .wizard>div.wizard-inner {

        margin-bottom: 0;

    }
</style>
<section class="signup-step-containerXXXX">

    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-md-12">
                <div class="wizard">
                    <div class="wizard-inner">
                        <div class="connecting-line"></div>
                        <ul class="nav nav-tabsxxx">
                            <li role="presentation" class="{{$active == 'registration' ? 'active' : 'disabled'}}">
                                <a href="#step1" aria-expanded="true"><span class="round-tab mdi mdi-account-plus mdi-24px"></span> <i>Sign up</i></a>
                            </li>
                            <li role="presentation" class="{{$active == 'Payment' ? 'active' : 'disabled'}}">
                                <a href="#step2" aria-expanded="false"><span class="round-tab mdi mdi-credit-card mdi-24px"></span> <i>Payment</i></a>
                            </li>
                            <li role="presentation" class="{{$active == 'Profile' ? 'active' : ''}}">
                                <a href="{{$active == 'Profile' ? '#' : '?step=profile'}}"><span class="round-tab mdi mdi-account-details mdi-24px"></span> <i>Profile details</i></a>
                            </li>
                            <li role="presentation" class="{{$active == 'Audition' ? 'active' : ''}}">
                                <a href="{{$active == 'Audition' ? '#' : '?step=audition'}}"><span class="round-tab mdi mdi-dance-ballroom mdi-24px"></span> <i>Audition details</i></a>
                            </li>
                            <li role="presentation" class="{{$active == 'upload' ? 'active' : 'disabled'}}">
                                <a href="#step5"><span class="round-tab mdi mdi-upload mdi-24px"></span> <i>Upload Video</i></a>
                            </li>
                        </ul>
                    </div>


                </div>
            </div>
        </div>
    </div>
</section>
