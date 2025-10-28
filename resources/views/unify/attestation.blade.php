@include('partials.invoice.head')

<div class="tm_container">
    <div class="tm_invoice_wrap">
      <div class="tm_invoice tm_style2" id="tm_download_section">
        <div class="tm_invoice_in">
          <div class="tm_invoice_content">
            <div class="tm_invoice_head tm_mb30">
              <div class="tm_invoice_left">
                <div class="tm_logo"><img src="{{asset('site/images/logo.png')}}" alt="Logo" class="w-full h-auto"></div>
              </div>
              <div class="tm_invoice_right tm_text_right">
                  <b class="tm_f20 tm_medium tm_primary_color">ATTESTATION D'OUVERTURE DE COMPTE</b>
                </div>
            </div>
              <div class="tm_invoice_info tm_mb25">
                <div class="tm_invoice_info_left">
                  <p class="tm_mb17">
                    <b class="tm_f18 tm_primary_color"><u>NUMÉRO DE COMPTE</u></b> <br><br>
                    <b class="tm_f18 tm_primary_color">{{ $data['ipaki_id']}}</b> <br>
                  </p>
                </div>
                <div class="tm_invoice_info_right">
                  <div class="tm_grid_row tm_col_3 tm_col_2_sm tm_invoice_info_in tm_gray_bg tm_round_border">
                    <div>
                      <h6>DATE DU JOUR</h6> <br>
                      <b class="tm_primary_color">{{ $data['date']->format('d-m-Y')}}</b>
                    </div>
                    <div>
                      <h6>TYPE DE PERSONNE</h6> <br>
                      <b class="tm_primary_color">{{ $data['type']}}</b>
                    </div>
                  </div>
                </div>
              </div>
            <div class="tm_table tm_style1">
              <div class="tm_round_border">
                <div class="tm_table_responsive">
                  <table>
                    <thead>
                      <tr>
                        <th class="tm_width_2 tm_semi_bold tm_primary_color">Raison sociale</th>
                        <th class="tm_width_2 tm_semi_bold tm_primary_color">Adresse</th>
                        <th class="tm_width_2 tm_semi_bold tm_primary_color">NINEA</th>
                        <th class="tm_width_2 tm_semi_bold tm_primary_color">RC</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="tm_width_2">{{ $data['social_reason']}}</td>
                        <td class="tm_width_2">{{ $data['address']}}</td>
                        <td class="tm_width_2">{{ $data['ninea']}}</td>
                        <td class="tm_width_2">{{ $data['rc']}}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="tm_invoice_btns tm_hide_print">
        <a href="javascript:window.print()" class="tm_invoice_btn tm_color1">
          <span class="tm_btn_icon">
            <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><path d="M384 368h24a40.12 40.12 0 0040-40V168a40.12 40.12 0 00-40-40H104a40.12 40.12 0 00-40 40v160a40.12 40.12 0 0040 40h24" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"/><rect x="128" y="240" width="256" height="208" rx="24.32" ry="24.32" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"/><path d="M384 128v-24a40.12 40.12 0 00-40-40H168a40.12 40.12 0 00-40 40v24" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"/><circle cx="392" cy="184" r="24" fill='currentColor'/></svg>
          </span>
          <span class="tm_btn_text">Print</span>
        </a>
        <button id="tm_download_btn" class="tm_invoice_btn tm_color2">
          <span class="tm_btn_icon">
            <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><path d="M320 336h76c55 0 100-21.21 100-75.6s-53-73.47-96-75.6C391.11 99.74 329 48 256 48c-69 0-113.44 45.79-128 91.2-60 5.7-112 35.88-112 98.4S70 336 136 336h56M192 400.1l64 63.9 64-63.9M256 224v224.03" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/></svg>
          </span>
          <span class="tm_btn_text">Download</span>
        </button>
      </div>
    </div>
  </div>

  @include('partials.invoice.js')
