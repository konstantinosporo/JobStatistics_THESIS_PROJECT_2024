    <div id="myCarousel" class="carousel slide shadow-lg" data-bs-ride="carousel">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true"
          aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active">

          <svg class="bd-placeholder-img" xmlns='http://www.w3.org/2000/svg' width='40%' height='300'
            viewBox='0 0 800 800'>
            <rect fill='#330033' width='800' height='800' />
            <g fill='none' stroke='#404' stroke-width='1'>
              <path
                d='M769 229L1037 260.9M927 880L731 737 520 660 309 538 40 599 295 764 126.5 879.5 40 599-197 493 102 382-31 229 126.5 79.5-69-63' />
              <path d='M-31 229L237 261 390 382 603 493 308.5 537.5 101.5 381.5M370 905L295 764' />
              <path
                d='M520 660L578 842 731 737 840 599 603 493 520 660 295 764 309 538 390 382 539 269 769 229 577.5 41.5 370 105 295 -36 126.5 79.5 237 261 102 382 40 599 -69 737 127 880' />
              <path d='M520-140L578.5 42.5 731-63M603 493L539 269 237 261 370 105M902 382L539 269M390 382L102 382' />
              <path
                d='M-222 42L126.5 79.5 370 105 539 269 577.5 41.5 927 80 769 229 902 382 603 493 731 737M295-36L577.5 41.5M578 842L295 764M40-201L127 80M102 382L-261 269' />
            </g>
            <g fill='#505'>
              <circle cx='769' cy='229' r='5' />
              <circle cx='539' cy='269' r='5' />
              <circle cx='603' cy='493' r='5' />
              <circle cx='731' cy='737' r='5' />
              <circle cx='520' cy='660' r='5' />
              <circle cx='309' cy='538' r='5' />
              <circle cx='295' cy='764' r='5' />
              <circle cx='40' cy='599' r='5' />
              <circle cx='102' cy='382' r='5' />
              <circle cx='127' cy='80' r='5' />
              <circle cx='370' cy='105' r='5' />
              <circle cx='578' cy='42' r='5' />
              <circle cx='237' cy='261' r='5' />
              <circle cx='390' cy='382' r='5' />
            </g>
          </svg>
          <div class="container ">
            <div class="carousel-caption text-start">
              <h2>@lang('messages.user_carousel.welcome')
                <small class="badge rounded-pill text-bg-primary p-1 fw-normal ms-2 shadow-lg">@lang('messages.recruiter_carousel.for_recruiter')
                </small>
              </h2>
              <p>@lang('messages.recruiter_carousel.carousel_job') </p>
              <p><a class="btn btn-sm btn-primary shadow"
                  href="{{ route('recruiter.job_listings.view') }}">@lang('messages.recruiter.job_listing')</a></p>
            </div>
          </div>
        </div>
        <div class="carousel-item">

          <svg class="bd-placeholder-img" xmlns='http://www.w3.org/2000/svg' width='130%' height='300'
            viewBox='0 0 800 800'>
            <rect fill='#008080' width='800' height='800' />
            <g fill='none' stroke='#FFD700' stroke-width='1'>
              <path
                d='M769 229L1037 260.9M927 880L731 737 520 660 309 538 40 599 295 764 126.5 879.5 40 599-197 493 102 382-31 229 126.5 79.5-69-63' />
              <path d='M-31 229L237 261 390 382 603 493 308.5 537.5 101.5 381.5M370 905L295 764' />
              <path
                d='M520 660L578 842 731 737 840 599 603 493 520 660 295 764 309 538 390 382 539 269 769 229 577.5 41.5 370 105 295 -36 126.5 79.5 237 261 102 382 40 599 -69 737 127 880' />
              <path d='M520-140L578.5 42.5 731-63M603 493L539 269 237 261 370 105M902 382L539 269M390 382L102 382' />
              <path
                d='M-222 42L126.5 79.5 370 105 539 269 577.5 41.5 927 80 769 229 902 382 603 493 731 737M295-36L577.5 41.5M578 842L295 764M40-201L127 80M102 382L-261 269' />
            </g>
            <g fill='#800080'>
              <circle cx='769' cy='229' r='16' />
              <circle cx='539' cy='269' r='16' />
              <circle cx='603' cy='493' r='16' />
              <circle cx='731' cy='737' r='16' />
              <circle cx='520' cy='660' r='16' />
              <circle cx='309' cy='538' r='16' />
              <circle cx='295' cy='764' r='16' />
              <circle cx='40' cy='599' r='16' />
              <circle cx='102' cy='382' r='16' />
              <circle cx='127' cy='80' r='16' />
              <circle cx='370' cy='105' r='16' />
              <circle cx='578' cy='42' r='16' />
              <circle cx='237' cy='261' r='16' />
              <circle cx='390' cy='382' r='16' />
            </g>
          </svg>

          <div class="container">
            <div class="carousel-caption">
              <h2>@lang('messages.recruiter_carousel.contact_applicant_cv')</h2>
              <p>@lang('messages.recruiter_carousel.carousel_cv')</p>
              <p><a class="btn btn-sm btn-primary shadow"
                  href="{{ route('job_listings.showApplicants') }}">@lang('messages.recruiter_carousel.view_applicants')</a></p>
            </div>
          </div>
        </div>
        <div class="carousel-item">
          <svg class="bd-placeholder-img shadow" xmlns='http://www.w3.org/2000/svg' width='160%' height='300'
            viewBox='0 0 800 800'>
            <rect fill='#056369' width='800' height='800' />
            <g fill='none' stroke='#4878A5' stroke-width='1'>
              <path
                d='M769 229L1037 260.9M927 880L731 737 520 660 309 538 40 599 295 764 126.5 879.5 40 599-197 493 102 382-31 229 126.5 79.5-69-63' />
              <path d='M-31 229L237 261 390 382 603 493 308.5 537.5 101.5 381.5M370 905L295 764' />
              <path
                d='M520 660L578 842 731 737 840 599 603 493 520 660 295 764 309 538 390 382 539 269 769 229 577.5 41.5 370 105 295 -36 126.5 79.5 237 261 102 382 40 599 -69 737 127 880' />
              <path d='M520-140L578.5 42.5 731-63M603 493L539 269 237 261 370 105M902 382L539 269M390 382L102 382' />
              <path
                d='M-222 42L126.5 79.5 370 105 539 269 577.5 41.5 927 80 769 229 902 382 603 493 731 737M295-36L577.5 41.5M578 842L295 764M40-201L127 80M102 382L-261 269' />
            </g>
            <g fill='#E5E5E5'>
              <circle cx='769' cy='229' r='5' />
              <circle cx='539' cy='269' r='5' />
              <circle cx='603' cy='493' r='5' />
              <circle cx='731' cy='737' r='5' />
              <circle cx='520' cy='660' r='5' />
              <circle cx='309' cy='538' r='5' />
              <circle cx='295' cy='764' r='5' />
              <circle cx='40' cy='599' r='5' />
              <circle cx='102' cy='382' r='5' />
              <circle cx='127' cy='80' r='5' />
              <circle cx='370' cy='105' r='5' />
              <circle cx='578' cy='42' r='5' />
              <circle cx='237' cy='261' r='5' />
              <circle cx='390' cy='382' r='5' />
            </g>
          </svg>

          <div class="container shadow">
            <div class="carousel-caption text-end">
              <h2>@lang('messages.recruiter_carousel.message_applicant')</h2>
              <p>@lang('messages.recruiter_carousel.carousel_message')</p>
              <p><a class="btn btn-sm btn-primary shadow"
                  href="{{ route('recruiter.messages.index') }}">@lang('messages.recruiter_carousel.send_message')</a></p>
            </div>
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
