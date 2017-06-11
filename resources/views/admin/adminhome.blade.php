<style>
    #yearclass{

       text-align: right;

    }



</style>
<script src= "https://cdn.zingchart.com/zingchart.min.js"></script>
<script> zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
    ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9","ee6b7db5b51705a13dc2339db3edaf6d"];</script>
@extends('admin.master')
@section('content')
@section('title','Home')
       <section class="content">
           <div class="row">
           


               <div class="col-lg-12 col-xs-12">

                   @include('admin/chart/caseChart')
                   @include('admin/chart/coartChart')

                   <div class="col-lg-12 col-xs-12"></div>
                   <div class="col-lg-12 col-xs-12"></div>
                   <div class="col-lg-12 col-xs-12"></div>
                   <div class="col-lg-12 col-xs-12"></div>
                   <div class="col-lg-12 col-xs-12"></div>
                   <div class="col-lg-12 col-xs-12"></div>
                   <div class="col-lg-12 col-xs-12"></div>
                   <div class="col-lg-12 col-xs-12"></div>
                   <div class="col-lg-12 col-xs-12"></div>


                   @include('admin/chart/InvestigationChart')
                   @include('admin/chart/ChargesheetChart')

               </div>




               <div class="col-lg-12 col-xs-12"></div>
               <div class="col-lg-12 col-xs-12"></div>
               <div class="col-lg-12 col-xs-12"></div>
               <div class="col-lg-12 col-xs-12"></div>
               <div class="col-lg-12 col-xs-12"></div>
               <div class="col-lg-12 col-xs-12"></div>
               <div class="col-lg-12 col-xs-12"></div>
               <div class="col-lg-12 col-xs-12"></div>
               <div class="col-lg-12 col-xs-12"></div>
                   <div class="col-lg-12 col-xs-12">
                   @include('admin/chart/convictChart')

            </div>
           </div>
       </section>


@endsection