{{--
    แปลงมาจาก lms-airasia-html/contact.php
--}}
@extends('layouts.mainlayout')

@section('title', 'Contact')

@section('content')

    {{-- Page Banner --}}
    <section class="page-banner">

        <div class="page-banner-inner">

            <h1 class="page-title">
                Contact
            </h1>

            <div class="breadcrumb-area">
                <a href="{{ route('home') }}">Homepage</a>
                <span class="separator">/</span>
                <span class="current">Contact</span>
            </div>

        </div>

    </section>

    {{-- Contact Content --}}
    <div class="contact-main">

        <div class="content-wrapper">

            <form class="contact-box" method="POST" action="#">
                @csrf

                {{-- First Name / Last Name --}}
                <div class="contact-row">

                    <div class="contact-column">
                        <label class="contact-label" for="first_name">First Name</label>
                        <input type="text" id="first_name" name="first_name" class="contact-input" placeholder="First Name">
                    </div>

                    <div class="contact-column">
                        <label class="contact-label" for="last_name">Last Name</label>
                        <input type="text" id="last_name" name="last_name" class="contact-input" placeholder="Last Name">
                    </div>

                </div>

                {{-- Phone / E-Mail --}}
                <div class="contact-row">

                    <div class="contact-column">
                        <label class="contact-label" for="phone">Phone</label>
                        <input type="text" id="phone" name="phone" class="contact-input" placeholder="Phone">
                    </div>

                    <div class="contact-column">
                        <label class="contact-label" for="email">E-Mail</label>
                        <input type="email" id="email" name="email" class="contact-input" placeholder="E-Mail">
                    </div>

                </div>

                {{-- Title --}}
                <div class="contact-field">
                    <label class="contact-label" for="title">Title</label>
                    <input type="text" id="title" name="title" class="contact-input" placeholder="Title">
                </div>

                {{-- Details --}}
                <div class="contact-field">
                    <label class="contact-label" for="details">Details</label>
                    <textarea id="details" name="details" class="contact-textarea" placeholder="Details"></textarea>
                </div>

                {{-- Captcha --}}
                <div class="captcha-area">
                    <div class="captcha-checkbox"></div>
                    <div class="captcha-text">I'm not a robot</div>
                    <div class="captcha-logo">
                        <div class="captcha-logo-icon">&#8635;</div>
                        reCAPTCHA
                    </div>
                </div>

                {{-- Send --}}
                <div class="send-area">
                    <button type="submit" class="send-btn">
                        SEND
                    </button>
                </div>

            </form>

        </div>

    </div>

@endsection
