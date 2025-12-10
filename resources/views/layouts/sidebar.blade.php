@if($admin)
<div class="sticky">
   <div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
   <div class="app-sidebar">
     <div class="side-header">
       <a class="header-brand1" href="{{ route('admin.dashboard') }}">
         <img src="/assets/images/bg/header-logo2.png" class="header-brand-img desktop-logo" alt="logo">
         <img src="/assets/images/bg/header-icon-logo2.png" class="header-brand-img toggle-logo" alt="logo">
         <img src="/assets/images/bg/header-icon-logo2.png" class="header-brand-img light-logo" alt="logo">
         <img src="/assets/images/bg/header-logo2.png" class="header-brand-img light-logo1" alt="logo">
       </a>
       <!-- LOGO -->
     </div>
     <div class="main-sidemenu">
       <div class="slide-left disabled" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
           width="24" height="24" viewBox="0 0 24 24">
           <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z" />
         </svg></div>
       <ul class="side-menu">
         <li class="sub-category">
           <h3>Main</h3>
         </li>
         <li @class(['slide', 'active' => $active === 'dashboard'])>
           <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('admin.dashboard') }}">
            <i class="side-menu__icon fa-regular fa-house"></i>
            <span class="side-menu__label">Dashboard</span>
         </a>
         </li>
         <li class="slide">
            <a  @class(['side-menu__item', 'has-link', 'active' => preg_match('/users.*/', $active)]) data-bs-toggle="slide" href="{{  route('admin.users.index')}}">
             <i class="side-menu__icon fa-regular fa-users"></i>
             <span class="side-menu__label">Users</span>
          </a>
          </li>
         <li class="sub-category">
           <h3>Ads</h3>
         </li>
         <li @class(['slide', 'is-expanded' => preg_match('/ads.*/', $active)])>
           <a @class(['side-menu__item', 'has-link', 'active' => preg_match('/ads.*/', $active)]) data-bs-toggle="slide" href="javascript:void(0)"><i
               class="side-menu__icon fa-regular fa-cube"></i><span class="side-menu__label">Ads</span><i
               class="fa-light fa-chevron-right fa-2xs"></i>
           </a>
           <ul @class(['slide-menu', 'open' => preg_match('/ads.*/', $active)])>
             <li class="panel sidetab-menu">
               <div class="panel-body tabs-menu-body p-0 border-0">
                 <div class="tab-content">
                   <div class="tab-pane active" id="side1">
                     <ul class="sidemenu-list">
                       <li><a href="{{ route('admin.ads.index') }}" @class(['slide-item', 'active' => $active === 'ads.all'])> All Listings</a></li>
                       <li><a href="{{ route('admin.ads.active') }}" @class(['slide-item', 'active' => $active === 'ads.active'])> Active Listings</a></li>
                       <li><a href="{{ route('admin.ads.upcoming') }}" @class(['slide-item', 'active' => $active === 'ads.upcoming'])> Upcoming Listings</a></li>
                       <li><a href="{{ route('admin.ads.expired') }}" @class(['slide-item', 'active' => $active === 'ads.expired'])> Expired Listings</a></li>
                     </ul>
                   </div>
                 </div>
               </div>
             </li>
           </ul>
         </li>
         <li class="slide">
          <a @class(['side-menu__item', 'has-link', 'active' => $active === 'bids']) data-bs-toggle="slide" href="{{ route('admin.bids.index') }}">
            <i class="side-menu__icon fa-regular fa-gavel"></i>
            <span class="side-menu__label">Bids</span>
           </a>
         </li>
         <li class="sub-category">
           <h3>Payments</h3>
         </li>
         <li @class(['slide', 'is-expanded' => preg_match('/payments.*/', $active)])>
           <a @class(['side-menu__item', 'has-link', 'active' => preg_match('/payments.*/', $active)]) data-bs-toggle="slide" href="javascript:void(0)"><i
               class="side-menu__icon fa-light fa-credit-card"></i><span class="side-menu__label">Payments</span><i
               class="fa-light fa-chevron-right fa-2xs"></i>
           </a>
           <ul @class(['slide-menu', 'open' => preg_match('/payments.*/', $active)])>
             <li class="panel sidetab-menu">
               <div class="panel-body tabs-menu-body p-0 border-0">
                 <div class="tab-content">
                   <div class="tab-pane active" id="side9">
                     <ul class="sidemenu-list">
                       <li><a href="{{ route('admin.payments.index') }}" @class(['slide-item', 'active' => $active === 'payments.all'])> All Payments</a></li>
                       <li><a href="{{ route('admin.payments.pending') }}" @class(['slide-item', 'active' => $active === 'payments.pending'])> Pending Payments</a></li>
                       <li><a href="{{ route('admin.payments.success') }}" @class(['slide-item', 'active' => $active === 'payments.successful'])> Successful Payments</a></li>
                       <li><a href="{{ route('admin.payments.failed') }}" @class(['slide-item', 'active' => $active === 'payments.failed'])> Failed Payments</a></li>
                     </ul>
                   </div>
                 </div>
               </div>
             </li>
           </ul>
         </li>
         <li @class(['slide', 'is-expanded' => preg_match('/payouts.*/', $active)])>
           <a @class(['side-menu__item', 'has-link', 'active' => preg_match('/payouts.*/', $active)]) data-bs-toggle="slide" href="javascript:void(0)"><i
               class="side-menu__icon fa-regular fa-money-check"></i><span class="side-menu__label">Payouts</span><i
               class="fa-light fa-chevron-right fa-2xs"></i>
           </a>
           <ul @class(['slide-menu', 'open' => preg_match('/payouts.*/', $active)])>
             <li class="panel sidetab-menu">
               <div class="panel-body tabs-menu-body p-0 border-0">
                 <div class="tab-content">
                   <div class="tab-pane active" id="side13">
                     <ul class="sidemenu-list">
                       <li><a href="{{ route('admin.payouts.index') }}" @class(['slide-item', 'active' => $active === 'payouts.all'])> All Payouts</a></li>
                       <li><a href="{{ route('admin.payouts.pending') }}" @class(['slide-item', 'active' => $active === 'payouts.pending'])> Pending Payouts</a></li>
                       <li><a href="{{ route('admin.payouts.success') }}" @class(['slide-item', 'active' => $active === 'payouts.successful'])> Successful Payouts</a></li>
                       <li><a href="{{ route('admin.payouts.failed') }}" @class(['slide-item', 'active' => $active === 'payouts.failed'])> Failed Payouts</a></li>
                     </ul>
                   </div>
                 </div>
               </div>
             </li>
           </ul>
         </li>
         <li class="slide">
          <a @class(['side-menu__item', 'has-link', 'active' => $active === 'payout-methods']) data-bs-toggle="slide" href="{{route('admin.payout-methods.index')}}">
           <i class="side-menu__icon fa-regular fa-building-columns"></i>
           <span class="side-menu__label">Methods</span>
          </a>
         </li>
         <li class="sub-category">
           <h3>General</h3>
         </li>
         <li>
          <a  @class(['side-menu__item', 'has-link', 'active' => preg_match('/media.*/', $active)]) data-bs-toggle="slide" href="{{ route('admin.media.index') }}">
           <i class="side-menu__icon fa-regular  fa-pen-to-square"></i>
           <span class="side-menu__label">Media</span>
          </a>
         </li>
         <li @class(['slide', 'is-expanded' => preg_match('/blogs.*/', $active)])>
           <a @class(['side-menu__item', 'has-link', 'active' => preg_match('/blogs.*/', $active)]) data-bs-toggle="slide" href="javascript:void(0)"><i
               class="side-menu__icon fa-regular fa-pen-to-square"></i><span class="side-menu__label">Blogs</span><i
               class="fa-light fa-chevron-right fa-2xs"></i>
           </a>
           <ul @class(['slide-menu', 'open' => preg_match('/blogs.*/', $active)])>
             <li class="panel sidetab-menu">
               <div class="panel-body tabs-menu-body p-0 border-0">
                 <div class="tab-content">
                   <div class="tab-pane active" id="side33">
                     <ul class="sidemenu-list">
                       <li><a href="{{ route('admin.blogs.index') }}" @class(['slide-item', 'active' => $active === 'blogs.all'])>All Blogs</a></li>
                       <li><a href="{{ route('admin.blogs.create') }}" @class(['slide-item', 'active' => $active === 'blogs.create'])> Create Blog</a></li>
                       <li><a href="{{ route('admin.comments.index') }}" @class(['slide-item', 'active' => $active === 'blogs.comments'])> All Comments</a></li>
                     </ul>
                   </div>
                 </div>
               </div>
             </li>
           </ul>
         </li>
         <li class="slide">
           <a @class(['side-menu__item', 'has-link', 'active' => preg_match('/support.*/', $active)]) data-bs-toggle="slide" href="javascript:void(0)"><i
               class="side-menu__icon fa-regular fa-messages"></i><span class="side-menu__label">Support</span><i
               class="fa-light fa-chevron-right fa-2xs"></i>
           </a>
           <ul class="slide-menu">
             <li class="panel sidetab-menu">
               <div class="panel-body tabs-menu-body p-0 border-0">
                 <div class="tab-content">
                   <div class="tab-pane active" id="side37">
                     <ul class="sidemenu-list">
                       <li><a href="{{ route('admin.support.index') }}" @class(['slide-item', 'active' => $active === 'support.all'])> All Tickets</a></li>
                       <li><a href="{{ route('admin.support.pending') }}" @class(['slide-item', 'active' => $active === 'support.pending'])> Pending Tickets</a></li>
                       <li><a href="{{ route('admin.support.resolved') }}" @class(['slide-item', 'active' => $active === 'support.resolved'])> Resolved Tickets</a></li>
                       <li><a href="{{ route('admin.support.create') }}" @class(['slide-item', 'active' => $active === 'support.create'])> Create Ticket</a></li>
                     </ul>
                   </div>
                 </div>
               </div>
             </li>
           </ul>
         </li>
       </ul>
       <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24"
           height="24" viewBox="0 0 24 24">
           <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z" />
         </svg></div>
     </div>
   </div>
</div>
@else
<div class="col-lg-3">
    <div class="nav flex-column nav-pills gap-4 wow fadeInUp" data-wow-duration="1.5s" data-wow-delay=".2s" style="visibility: visible; animation-duration: 1.5s; animation-delay: 0.2s; animation-name: fadeInUp;">
       <a href="{{ route('user.dashboard') }}" @class(['nav-link', 'nav-btn-style', 'mx-auto', 'mb-20', 'active' => $active === 'dashboard'])>
          <svg width="22" height="22" viewBox="0 0 22 22"
             xmlns="http://www.w3.org/2000/svg">
             <g clip-path="url(#clip0_388_603)">
                <path
                   d="M8.47911 7.33339H1.60411C0.719559 7.33339 0 6.61383 0 5.72911V1.60411C0 0.719559 0.719559 0 1.60411 0H8.47911C9.36383 0 10.0834 0.719559 10.0834 1.60411V5.72911C10.0834 6.61383 9.36383 7.33339 8.47911 7.33339ZM1.60411 1.375C1.47772 1.375 1.375 1.47772 1.375 1.60411V5.72911C1.375 5.85567 1.47772 5.95839 1.60411 5.95839H8.47911C8.60567 5.95839 8.70839 5.85567 8.70839 5.72911V1.60411C8.70839 1.47772 8.60567 1.375 8.47911 1.375H1.60411Z">
                </path>
                <path
                   d="M8.47911 22H1.60411C0.719559 22 0 21.2805 0 20.3959V10.7709C0 9.88618 0.719559 9.16663 1.60411 9.16663H8.47911C9.36383 9.16663 10.0834 9.88618 10.0834 10.7709V20.3959C10.0834 21.2805 9.36383 22 8.47911 22ZM1.60411 10.5416C1.47772 10.5416 1.375 10.6443 1.375 10.7709V20.3959C1.375 20.5223 1.47772 20.625 1.60411 20.625H8.47911C8.60567 20.625 8.70839 20.5223 8.70839 20.3959V10.7709C8.70839 10.6443 8.60567 10.5416 8.47911 10.5416H1.60411Z">
                </path>
                <path
                   d="M20.3953 22H13.5203C12.6356 22 11.916 21.2805 11.916 20.3959V16.2709C11.916 15.3862 12.6356 14.6667 13.5203 14.6667H20.3953C21.2798 14.6667 21.9994 15.3862 21.9994 16.2709V20.3959C21.9994 21.2805 21.2798 22 20.3953 22ZM13.5203 16.0417C13.3937 16.0417 13.291 16.1444 13.291 16.2709V20.3959C13.291 20.5223 13.3937 20.625 13.5203 20.625H20.3953C20.5217 20.625 20.6244 20.5223 20.6244 20.3959V16.2709C20.6244 16.1444 20.5217 16.0417 20.3953 16.0417H13.5203Z">
                </path>
                <path
                   d="M20.3953 12.8334H13.5203C12.6356 12.8334 11.916 12.1138 11.916 11.2291V1.60411C11.916 0.719559 12.6356 0 13.5203 0H20.3953C21.2798 0 21.9994 0.719559 21.9994 1.60411V11.2291C21.9994 12.1138 21.2798 12.8334 20.3953 12.8334ZM13.5203 1.375C13.3937 1.375 13.291 1.47772 13.291 1.60411V11.2291C13.291 11.3557 13.3937 11.4584 13.5203 11.4584H20.3953C20.5217 11.4584 20.6244 11.3557 20.6244 11.2291V1.60411C20.6244 1.47772 20.5217 1.375 20.3953 1.375H13.5203Z">
                </path>
             </g>
             <defs>
                <clipPath id="clip0_388_603">
                   <rect width="22" height="22" fill="white"></rect>
                </clipPath>
             </defs>
          </svg>
          Dashboard
       </a>
       <a href="{{ route('user.profile') }}" @class(['nav-link', 'nav-btn-style', 'mx-auto', 'mb-20', 'active' => $active === 'profile'])>
          <i class="lar la-user"></i>
          <svg width="22" height="22" viewBox="0 0 22 22"
             xmlns="http://www.w3.org/2000/svg">
             <path
                d="M18.7782 14.2218C17.5801 13.0237 16.1541 12.1368 14.5982 11.5999C16.2646 10.4522 17.3594 8.53136 17.3594 6.35938C17.3594 2.85282 14.5066 0 11 0C7.49345 0 4.64062 2.85282 4.64062 6.35938C4.64062 8.53136 5.73543 10.4522 7.40188 11.5999C5.84598 12.1368 4.41994 13.0237 3.22184 14.2218C1.14421 16.2995 0 19.0618 0 22H1.71875C1.71875 16.8823 5.88229 12.7188 11 12.7188C16.1177 12.7188 20.2812 16.8823 20.2812 22H22C22 19.0618 20.8558 16.2995 18.7782 14.2218ZM11 11C8.44117 11 6.35938 8.91825 6.35938 6.35938C6.35938 3.8005 8.44117 1.71875 11 1.71875C13.5588 1.71875 15.6406 3.8005 15.6406 6.35938C15.6406 8.91825 13.5588 11 11 11Z">
             </path>
          </svg>
          My Profile
       </a>
       <a href="{{ route('user.listing-bids') }}" @class(['nav-link', 'nav-btn-style', 'mx-auto', 'mb-20', 'active' => $active === 'bidding'])>
          <svg width="22" height="22" viewBox="0 0 22 22" xmlns="http://www.w3.org/2000/svg">
             <path
                d="M19.7115 18.1422L18.729 5.7622C18.6678 4.96461 17.9932 4.3398 17.1933 4.3398H15.2527V4.25257C15.2527 1.90768 13.345 0 11.0002 0C8.65527 0 6.74758 1.90768 6.74758 4.25257V4.3398H4.80703C4.00708 4.3398 3.33251 4.96457 3.2715 5.76052L2.28872 18.1439C2.21266 19.1354 2.55663 20.1225 3.23235 20.852C3.90808 21.5815 4.86598 22 5.86041 22H16.1399C17.1342 22 18.0922 21.5816 18.768 20.852C19.4437 20.1224 19.7876 19.1354 19.7115 18.1422ZM8.03622 4.25257C8.03622 2.61826 9.36588 1.28863 11.0002 1.28863C12.6344 1.28863 13.9641 2.6183 13.9641 4.25257V4.3398H8.03622V4.25257ZM17.8225 19.9764C17.3835 20.4503 16.7859 20.7114 16.1399 20.7114H5.86045C5.21437 20.7114 4.61685 20.4503 4.17779 19.9764C3.73878 19.5024 3.5242 18.8866 3.57352 18.2441L4.55622 5.86072C4.56619 5.73044 4.67636 5.62843 4.80703 5.62843H6.74758V7.21548C6.74758 7.57131 7.03607 7.8598 7.3919 7.8598C7.74772 7.8598 8.03622 7.57131 8.03622 7.21548V5.62843H13.9641V7.21548C13.9641 7.57131 14.2526 7.8598 14.6084 7.8598C14.9642 7.8598 15.2527 7.57131 15.2527 7.21548V5.62843H17.1933C17.324 5.62843 17.4341 5.73048 17.4443 5.86244L18.4267 18.2424C18.4762 18.8866 18.2615 19.5024 17.8225 19.9764Z">
             </path>
             <path
                d="M13.9035 10.9263C13.652 10.6746 13.244 10.6746 12.9924 10.9263L10.1154 13.8033L9.00909 12.697C8.75751 12.4454 8.34952 12.4454 8.0979 12.697C7.84627 12.9486 7.84627 13.3566 8.0979 13.6082L9.65977 15.1701C9.78558 15.2959 9.9505 15.3588 10.1153 15.3588C10.2802 15.3588 10.4451 15.2959 10.5709 15.1701L13.9034 11.8375C14.1551 11.5858 14.1551 11.1779 13.9035 10.9263Z">
             </path>
          </svg>
          My Bids
       </a>
       <form action="{{ route('user.logout.handle') }}" method="POST">
        @csrf
        <button type="submit" @class(['nav-link', 'nav-btn-style', 'mx-auto'])>
            <svg width="22" height="22"
                viewBox="0 0 22 22" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_382_377)">
                    <path
                    d="M21.7273 10.4732L19.3734 8.81368C18.9473 8.51333 18.3574 8.81866 18.3574 9.34047V12.6595C18.3574 13.1834 18.9485 13.4856 19.3733 13.1863L21.7272 11.5268C22.0916 11.2699 22.0906 10.7294 21.7273 10.4732Z">
                    </path>
                    <path
                    d="M18.4963 15.1385C18.1882 14.9603 17.7939 15.0655 17.6156 15.3737C16.1016 17.9911 13.2715 19.7482 10.0374 19.7482C5.21356 19.7482 1.28906 15.8237 1.28906 11C1.28906 6.17625 5.21356 2.25171 10.0374 2.25171C13.2736 2.25171 16.1025 4.0105 17.6156 6.62617C17.7938 6.93434 18.1882 7.03949 18.4962 6.86138C18.8043 6.68315 18.9096 6.28887 18.7314 5.98074C16.9902 2.97053 13.738 0.962646 10.0374 0.962646C4.48967 0.962646 0 5.45184 0 11C0 16.5477 4.48919 21.0373 10.0374 21.0373C13.7396 21.0373 16.9909 19.028 18.7315 16.0191C18.9097 15.711 18.8044 15.3168 18.4963 15.1385Z">
                    </path>
                    <path
                    d="M7.05469 10.3555C6.69873 10.3555 6.41016 10.644 6.41016 11C6.41016 11.356 6.69873 11.6445 7.05469 11.6445H17.0677V10.3555H7.05469Z">
                    </path>
                </g>
                <defs>
                    <clipPath id="clip0_382_377">
                    <rect width="22" height="22"></rect>
                    </clipPath>
                </defs>
            </svg>
            Logout
        </button>
       </form>
    </div>
</div>
@endif
