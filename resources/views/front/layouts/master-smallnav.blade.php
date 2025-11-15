<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

  <head>
        <!-- Meta Tags -->
      <meta charset=utf-8>
      <meta name=locale content=ar>
      <meta name=google content=notranslate>
      <meta id=csrf-param-meta-tag name=csrf-param content=authenticity_token>
      <meta id=csrf-token-meta-tag name=csrf-token content>
      <meta id=english-canonical-url content>
      <!-- <meta name=twitter:widgets:csp content=on> -->
      <meta name=mobile-web-app-capable content=yes>
      <meta name=apple-mobile-web-app-capable content=yes>
      <meta name=application-name content= mubashar>
      <meta name=apple-mobile-web-app-title content= mubashar>
      <meta name=theme-color content=#ffffff>
      <meta name=msapplication-navbutton-color content=#ffffff>
      <meta name=apple-mobile-web-app-status-bar-style content=black-translucent>
      <meta name=msapplication-starturl content="/?utm_source=homescreen">

      <meta content="width=device-width, initial-scale=1, viewport-fit=cover" name=viewport>

  

      <meta name=description
          content="المنصة الرائدة في سوريا"
          >
      <title> @yield('title') </title>


        <link rel="stylesheet" href="{{ asset('assets/web/css/style-0.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/web/css/style-1.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/web/css/style-2.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/web/css/style-main.css') }}">


        
        <style>
            #map {
                height: 500px;
                width: 100%;
                border-radius: 15px;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
                margin: 20px auto;
            }

            .map-btn {
                display: block;
                margin: 15px auto;
                padding: 10px 20px;
                background: #4285F4;
                color: #fff;
                font-size: 16px;
                font-weight: bold;
                border: none;
                border-radius: 8px;
                cursor: pointer;
                text-decoration: none;
                text-align: center;
                transition: background 0.3s ease;
                width: fit-content;
            }

            .map-btn:hover {
                background: #3367D6;
            }
        </style>




        <style>
            .sf-hidden {
                display: none !important
            }
        </style>

  </head>

  
  <body class=with-new-header>

        <div id="galleryModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.9); justify-content:center; align-items:center; z-index:1000;">
            <span onclick="closeGallery()" style="position:absolute; top:20px; right:30px; color:white; font-size:32px; font-weight:bold; cursor:pointer;">&times;</span>
            
            <div style="position:relative; width:80%; max-width:900px; height:80%; display:flex; justify-content:center; align-items:center;">
                @foreach($ad->media as $i => $image)
                    <img src="{{ getMediaUrl($image->name, MEDIA_TYPES['image']) }}"
                        style="display:none; width:100%; height:100%; object-fit:contain; border-radius:8px;"
                        class="gallerySlide" id="slide{{ $i+1 }}">
                @endforeach

                {{-- أزرار التنقل --}}
                <a style="cursor:pointer; position:absolute; top:50%; left:10px; transform:translateY(-50%); font-size:32px; color:white; font-weight:bold;" onclick="plusSlides(-1)">&#10094;</a>
                <a style="cursor:pointer; position:absolute; top:50%; right:10px; transform:translateY(-50%); font-size:32px; color:white; font-weight:bold;" onclick="plusSlides(1)">&#10095;</a>
            </div>
        </div>
    <div id=flash-container class=flash-container role=alert aria-live=assertive></div>
    <div id=education-overlay-root></div>
    <div id=react-application data-application=true>
        <div dir=rtl>
            <div data-theme data-color-scheme=light data-testid=linaria-injector class="t1bgcr6e cjz5kiq"
                style=display:contents>
                <div>
                    <div>
                        <div
                            class="r9m3m4o atm_eohtre_1wfwpv5 atm_1gwwzir_u29brm atm_eohtre_mm87nz__jx8car atm_1gwwzir_rw9lz9__jx8car dir dir-rtl">
                            <div>
                                <div style=--homepage-font-ratio-increase:0
                                    class="m3wbj8l atm_lcucu6_exct8b atm_ys9she_69rp3d__jx8car atm_ys9she_12mkxmp__1z0u2lb atm_lcucu6_1tcgj5g__kgj4qw atm_lcucu6_1tcgj5g__oggzyc atm_lcucu6_1vi7ecw__1v156lz atm_lcucu6_1vi7ecw__qky54b atm_lcucu6_fyhuej__jx8car dir dir-rtl"
                                    data-nosnippet=true>
                                    <h1
                                        class="vsvqdle atm_3f_idpfg4 atm_7h_hxbz6r atm_7i_ysn8ba atm_e2_t94yts atm_ks_zryt35 atm_l8_idpfg4 atm_mk_stnw88 atm_vv_1q9ccgz atm_vy_t94yts dir dir-rtl">
                                        صفحة  mubashar الرئيسية</h1>
                                    <div class="w1hvh9qj atm_mk_1if85x1 atm_tk_idpfg4 atm_vy_1osqo2v atm_wq_b4wlg atm_h3_1wmurcz dir dir-rtl"
                                        data-testid=shimmer-css-variable-index-0 style=--dls-shimmer_count:0>
                                        <div data-pageslot=true
                                            class="c1yo0219 atm_9s_1txwivl_vmtskl atm_92_1yyfdc7_vmtskl atm_9s_1txwivl_9in345 atm_92_1yyfdc7_9in345 dir dir-rtl">
                                            <div style=display:contents>
                                                <header style=" margin-left: 25px;margin-right: 25px;   direction: ltr;" class="c1ftp51f atm_9s_1txwivl atm_fc_1yb4nlp atm_h_1h6ojuz atm_gi_xjk4d9 atm_j3_1vvhni0 atm_lk_1ph3nq8 atm_ll_1ph3nq8 atm_e2_u29brm atm_lk_n9wab5__1v156lz atm_ll_n9wab5__1v156lz atm_lk_dnsvzo__jx8car atm_ll_dnsvzo__jx8car atm_e2_rw9lz9__jx8car dir">
                                                     <a style="    width: 25%;" class="c13cw3wj atm_kd_glywfm atm_h_1h6ojuz atm_9s_116y0ak atm_e2_u29brm atm_mk_h2mmj6 atm_vh_nkobfv atm_wq_kb7nvz atm_uc_fg9k26 atm_3f_glywfm_jo46a5 atm_l8_idpfg4_jo46a5 atm_gi_idpfg4_jo46a5 atm_3f_glywfm_1icshfk atm_kd_glywfm_19774hq atm_5j_kitwna_vmtskl atm_6i_1fwxnve_vmtskl atm_92_1yyfdc7_vmtskl atm_fq_zt4szt_vmtskl atm_mk_stnw88_vmtskl atm_n3_zt4szt_vmtskl atm_tk_1fwxnve_vmtskl atm_uc_aaiy6o_9xuho3 atm_70_13dujet_9xuho3 atm_uc_glywfm_9xuho3_1rrf6b5 cbavvlr atm_7l_r0d14n atm_7l_r0d14n_pfnrn2 atm_7l_r0d14n_1nos8r dir dir-rtl"
                                                            aria-label="صفحة  mubashar الرئيسية" href="" >
                                                        <div class="l10sdlqs atm_9s_glywfm atm_9s_1ulexfb__1v156lz dir dir-rtl">
                                                            <img src="{{ asset('assets/web/image/logo.png') }}" style="    width: 50%;" alt="">
                                                        </div>
                                                        <div class="bpe4snb atm_9s_glywfm__1v156lz dir dir-rtl sf-hidden">
                                                            <img src="{{ asset('assets/web/image/logo.png') }}" style="    width: 50%;" alt="">

                                                        </div>
                                                     </a>
                                                    <form
                                                        class="f1hztvqy atm_vy_1osqo2v atm_e2_1osqo2v atm_mk_stnw88 atm_tk_idpfg4 atm_fq_idpfg4 atm_lh_ke7zzc atm_wq_idpfg4 dir dir-rtl"
                                                        role=search action=/homes>
                                                        <div class="csjaj27 atm_vy_1osqo2v atm_9s_1txwivl atm_h_1h6ojuz atm_ar_1bp4okc atm_mk_h2mmj6 atm_wq_kb7nvz atm_h3_ftgil2__jx8car dir dir-rtl"
                                                            style=transform:none>
                                                            <div>
                                                                <div class="t1omuab8 atm_gi_1w81u1x atm_uc_buyp69__1igb08s atm_vz_brmitn__1igb08s tgfth7w atm_k4_kb7nvz atm_ud_o03ep1 dir dir-rtl">
                                                                    <div style="    display: flex;" class="c1q7wpad atm_mk_h2mmj6 cearn0u atm_9s_11p5wf0 atm_dz_1a6ah5s atm_fc_1h6ojuz atm_h3_ftgil2 atm_cx_ldb6wv dir dir-rtl "  role=tablist>
                                                                        <a href=""
                                                                            role=tab aria-selected=false tabindex=-1
                                                                            data-tabid=tabBarItem-EXPERIENCES
                                                                            id=search-block-tab-EXPERIENCES
                                                                            class="{{ request()->query('category_id') == 15 ? 'active' : '' }} s5o62i6 atm_9j_tlke0l atm_vb_glywfm atm_kd_glywfm atm_3f_glywfm_jo46a5 atm_l8_idpfg4_jo46a5 atm_gi_idpfg4_jo46a5 atm_3f_glywfm_1icshfk atm_kd_glywfm_19774hq atm_5j_ftgil2_1w3cfyq atm_kd_19r6f69_1w3cfyq atm_kh_1y44olf_1w3cfyq w6avlzg atm_9s_1txwivl atm_h_1h6ojuz atm_gq_1fwxnve dir dir-rtl"
                                                                            data-happo-focus=false>
                                                                            <span class="slt01p9 atm_7l_1esdqks atm_ti_1q9ccgz sgwsc4z atm_9s_1ulexfb_vmtskl atm_92_1ahnjlt_vmtskl atm_cs_wp830q_vmtskl atm_e2_idpfg4_vmtskl atm_ks_15vqwwr_vmtskl atm_vl_15vqwwr_vmtskl w14w6ssu atm_c8_dlk8xv atm_g3_f6fqlb atm_7l_dezgoh_1nos8r w1limbpw atm_gz_ftgil2 dir dir-rtl"
                                                                                data-title="سيارات"
                                                                                aria-hidden=true>سيارات
                                                                                    <img src="{{ asset('assets/web/image/transport.png') }}"  alt="icon" />

                                                                            </span>
                                                                        </a>
                                                                        <a href=""
                                                                            role=tab aria-selected=true tabindex=0
                                                                            data-tabid=tabBarItem-STAYS id=search-block-tab-STAYS
                                                                            class="{{ request()->query('category_id') == 1 ? 'active' : '' }} s5o62i6 atm_9j_tlke0l atm_vb_glywfm atm_kd_glywfm atm_3f_glywfm_jo46a5 atm_l8_idpfg4_jo46a5 atm_gi_idpfg4_jo46a5 atm_3f_glywfm_1icshfk atm_kd_glywfm_19774hq atm_5j_ftgil2_1w3cfyq atm_kd_19r6f69_1w3cfyq atm_kh_1y44olf_1w3cfyq w6avlzg atm_9s_1txwivl atm_h_1h6ojuz atm_gq_1fwxnve w1ppews5 atm_gz_1lpd5c9 atm_lk_14y27yu dir dir-rtl"
                                                                            data-happo-focus=false>
                                                                            <span class="slt01p9 atm_ti_1q9ccgz sxeg3i2 atm_7l_dezgoh  sgwsc4z atm_9s_1ulexfb_vmtskl atm_92_1ahnjlt_vmtskl atm_cs_wp830q_vmtskl atm_e2_idpfg4_vmtskl atm_ks_15vqwwr_vmtskl atm_vl_15vqwwr_vmtskl w14w6ssu atm_c8_dlk8xv atm_g3_f6fqlb atm_7l_dezgoh_1nos8r wz3022t atm_gz_exct8b dir dir-rtl"
                                                                                data-title=البيوت aria-hidden=true>البيوت
                                                                                    <img src="{{ asset('assets/web/image/house.png') }}"  alt="icon" />

                                                                            </span>
                                                                            
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="i1hf2lh8 atm_mk_stnw88 atm_tk_idpfg4 atm_fq_idpfg4 atm_vy_1osqo2v atm_e2_u29brm atm_26_fi574f atm_tw_jp4btk atm_uc_18thpt6__1igb08s atm_92_10q8stu_9in345 atm_mk_stnw88_9in345 atm_6i_1n1ank9_9in345 atm_fq_idpfg4_9in345 atm_vy_1osqo2v_9in345 atm_e2_t94yts_9in345 atm_tw_jp4btk_9in345 atm_2d_1s7alg2_9in345 atm_uc_18thpt6_9in345_1igb08s atm_e2_rw9lz9__jx8car i1fcflgj atm_2d_1c1vgcy atm_tr_gkdz9o atm_tr_10i9rbn_9in345 atm_tr_102ee3i__jx8car atm_tr_c34r1j_9in345_jx8car dir dir-rtl"
                                                            style="transform: scaleY(1) !important">
                                                        </div>
                                                    </form>
                                                    <div
                                                        class="ogt7ox8 atm_mk_1n9t6rb atm_tk_idpfg4 atm_fq_idpfg4 atm_vy_auwlz6 atm_e2_1kxcs5u atm_wq_1m4mje8 atm_26_e5ic7o atm_k4_idpfg4 atm_mj_glywfm atm_uc_59s6ej dir dir-rtl">
                                                    </div>
                                                    <nav aria-label="الملف الشخصي" class="cg7l307 atm_mk_h2mmj6 atm_9s_1txwivl atm_h_1h6ojuz atm_fc_esu3gu atm_e2_u29brm dir dir-rtl">
                                                        <div
                                                            class="l3mxch7 atm_9s_1txwivl atm_am_1wugsn5 atm_fc_esu3gu atm_cx_1fwxnve atm_h_1h6ojuz atm_h0_1fwxnve l7hgz3h atm_9s_glywfm_1iyvsap_1a4xmnj dir dir-rtl">
                                                            <button type=button class="l1ovpqvx atm_1he2i46_1k8pnbi_10saat9 atm_yxpdqi_1pv6nv4_10saat9 atm_1a0hdzc_w1h1e8_10saat9 atm_2bu6ew_929bqk_10saat9 atm_12oyo1u_73u7pn_10saat9 atm_fiaz40_1etamxe_10saat9 c1nzsz0l atm_9j_tlke0l atm_9s_1o8liyq atm_gi_idpfg4 atm_mk_h2mmj6 atm_r3_1h6ojuz atm_rd_glywfm atm_3f_uuagnh atm_70_5j5alw atm_vy_1wugsn5 atm_tl_1gw4zv3 atm_bx_48h72j atm_c8_btzn9q atm_g3_1hr80sk atm_cs_10d11i2 atm_26_1i7d4jj atm_20_13viflf atm_7l_1ca5zq3 atm_4b_1oq6qme atm_6h_dpi2ty atm_66_nqa18y atm_kd_glywfm atm_jb_16cl52u atm_uc_1lizyuv atm_r2_1j28jx2 atm_1pgz0hy_kitwna atm_90hitl_1skhajo atm_q3c8am_1skhajo atm_17k63hd_gktfv atm_1artg4w_gktfv atm_16gn1vh_86zae atm_1nv7vqx_1s00pb0 atm_1ycj583_idpfg4 atm_bp5prx_1wugsn5 atm_pbz4zy_1j28jx2 atm_143zgh5_1ykuqvp atm_15vesau_1j28jx2 atm_jzguh3_1ykuqvp atm_ldn80t_1s640os atm_b9xxwi_1ykuqvp atm_114pxjm_1s640os atm_182m1vx_1ykuqvp atm_1h1macq_1j28jx2 atm_j7efc6_1gkufv3 atm_ksrr9c_13dujet atm_8w_1t7jgwy atm_l8_1svpwur atm_5j_gktfv atm_vv_1q9ccgz atm_9j_13gfvf7_1o5j5ji atm_vz_1e032xh_wc6gzy atm_uc_1no41w5_wc6gzy atm_uc_glywfm__1rrf6b5 atm_kd_glywfm_1w3cfyq atm_uc_aaiy6o_1w3cfyq atm_4b_1r2f4og_1w3cfyq atm_3f_glywfm_e4a3ld atm_l8_idpfg4_e4a3ld atm_gi_idpfg4_e4a3ld atm_3f_glywfm_1r4qscq atm_kd_glywfm_6y7yyg atm_uc_glywfm_1w3cfyq_1rrf6b5 atm_4b_1ymcg8c_1nos8r_uv4tnr atm_26_asnl7k_1nos8r_uv4tnr atm_7l_1etjrq5_1nos8r_uv4tnr atm_tr_c3l1w2_z5n1qr_uv4tnr atm_4b_1cpdnk2_pd0br1_uv4tnr atm_26_zp0x24_pd0br1_uv4tnr atm_7l_1n4947f_pd0br1_uv4tnr atm_4b_13y81g2_4fughm_uv4tnr atm_26_zsif75_4fughm_uv4tnr atm_7l_3x6mlv_4fughm_uv4tnr atm_tr_glywfm_4fughm_uv4tnr atm_4b_1cpdnk2_csw3t1 atm_26_zp0x24_csw3t1 atm_7l_1n4947f_csw3t1 atm_tr_c3l1w2_csw3t1 atm_7l_1jopa2a_pfnrn2 atm_4b_13y81g2_1o5j5ji atm_26_zsif75_1o5j5ji atm_7l_3x6mlv_1o5j5ji atm_k4_kb7nvz_1o5j5ji atm_tr_glywfm_1o5j5ji atm_rd_f546ox_1nos8r atm_rd_f546ox_pfnrn2 atm_rd_f546ox_1xfbuyq atm_26_1j28jx2_1w3cfyq atm_7l_jt7fhx_1w3cfyq atm_70_i8vlak_1w3cfyq dir dir-rtl">
                                                                <span data-button-content=true class="b1s4anc3 atm_9s_1cw04bb atm_rd_1kw7nm4 atm_vz_kcpwjc atm_uc_kkvtv4 dir dir-rtl">
                                                                    انضم كمعلن
                                                                </span>
                                                            </button>
                                                            {{-- <div class="cxd0wgg atm_mk_h2mmj6 atm_9s_1o8liyq atm_vh_nkobfv atm_h3_1wugsn5 atm_gq_1wugsn5 dir dir-rtl">
                                                                <button aria-expanded=false aria-label="اختيار اللغة والعملة" type=button
                                                                    class="l1ovpqvx atm_1he2i46_1k8pnbi_10saat9 atm_yxpdqi_1pv6nv4_10saat9 atm_1a0hdzc_w1h1e8_10saat9 atm_2bu6ew_929bqk_10saat9 atm_12oyo1u_73u7pn_10saat9 atm_fiaz40_1etamxe_10saat9 c11lr9v9 atm_1s_glywfm atm_5j_1ssbidh atm_9j_tlke0l atm_tl_1gw4zv3 atm_l8_idpfg4 atm_gi_idpfg4 atm_3f_glywfm atm_2d_v1pa1f atm_7l_lerloo atm_uc_19xs0gj atm_kd_glywfm atm_1i0qmk0_idpfg4 atm_teja2d_1erm3mr atm_1pgqari_1ykuqvp atm_1sq3y97_1erm3mr atm_2bdht_1ykuqvp atm_dscbz2_1erm3mr atm_1lwh1x6_1ykuqvp atm_1crt5n3_1erm3mr atm_1q1v3h9_1gkufv3 atm_1v02rxp_1erm3mr atm_1ofeedh_122qtur atm_1fklkm6_122qtur atm_fa50ew_1erm3mr atm_9y4brj_1j28jx2 atm_10zj5xa_1j28jx2 atm_pzdf76_1j28jx2 atm_1tv373o_1gkufv3 atm_1xmjjzz_1ylpe5n atm_nbjvyu_1ylpe5n atm_unmfjg_1yubz8m atm_mk_h2mmj6 atm_9s_116y0ak atm_fc_1h6ojuz atm_h_1h6ojuz atm_vy_1ylpe5n atm_e2_1ylpe5n atm_kd_glywfm_1w3cfyq atm_3f_glywfm_e4a3ld atm_l8_idpfg4_e4a3ld atm_gi_idpfg4_e4a3ld atm_3f_glywfm_1r4qscq atm_kd_glywfm_6y7yyg atm_9j_13gfvf7_1o5j5ji atm_uc_glywfm__1rrf6b5 atm_2d_j26ubc_1rqz0hn_uv4tnr atm_4b_zpisrj_1rqz0hn_uv4tnr atm_7l_oonxzo_4fughm_uv4tnr atm_2d_13vagss_4fughm_uv4tnr atm_2d_1lbyi75_1r92pmq_uv4tnr atm_4b_7hps52_1r92pmq_uv4tnr atm_tr_8dwpus_1k46luq_uv4tnr atm_3f_glywfm_jo46a5 atm_l8_idpfg4_jo46a5 atm_gi_idpfg4_jo46a5 atm_3f_glywfm_1icshfk atm_kd_glywfm_19774hq atm_uc_aaiy6o_1w3cfyq atm_70_glywfm_1w3cfyq atm_uc_glywfm_1w3cfyq_1rrf6b5 atm_70_1wx36md_9xuho3 atm_4b_1ukl3ww_9xuho3 atm_6h_1tpdecz_9xuho3 atm_66_nqa18y_9xuho3 atm_uc_g9he8m_9xuho3 atm_2d_ez5gio_1ul2smo atm_4b_botz5_1ul2smo atm_tr_8dwpus_d9f5ny atm_7l_oonxzo_1o5j5ji atm_2d_13vagss_1o5j5ji atm_k4_uk3aii_1o5j5ji atm_2d_1lbyi75_154oz7f atm_4b_7hps52_154oz7f atm_2d_il29g1_vmtskl atm_20_d71y6t_vmtskl atm_4b_thxgdg_vmtskl atm_6h_1ihynmr_vmtskl atm_66_nqa18y_vmtskl atm_92_1yyfdc7_vmtskl atm_9s_1ulexfb_vmtskl atm_mk_stnw88_vmtskl atm_tk_1ssbidh_vmtskl atm_fq_1ssbidh_vmtskl atm_tr_pryxvc_vmtskl atm_vy_12k9wfs_vmtskl atm_e2_33f83m_vmtskl atm_5j_wqrmaf_vmtskl dir dir-rtl">
                                                                    <span data-button-content=true class="b15up7el atm_vz_at6eh2 atm_uc_82skwb atm_mk_h2mmj6 atm_9s_116y0ak atm_fc_1h6ojuz atm_h_1h6ojuz atm_vy_1ylpe5n atm_e2_1ylpe5n dir dir-rtl">
                                                                        <svg xmlns=http://www.w3.org/2000/svg
                                                                            viewBox="0 0 16 16" aria-hidden=true
                                                                            role=presentation focusable=false
                                                                            style=display:block;height:16px;width:16px;fill:currentcolor>
                                                                            <path
                                                                                d="M8 .25a7.77 7.77 0 0 1 7.75 7.78 7.75 7.75 0 0 1-7.52 7.72h-.25A7.75 7.75 0 0 1 .25 8.24v-.25A7.75 7.75 0 0 1 8 .25zm1.95 8.5h-3.9c.15 2.9 1.17 5.34 1.88 5.5H8c.68 0 1.72-2.37 1.93-5.23zm4.26 0h-2.76c-.09 1.96-.53 3.78-1.18 5.08A6.26 6.26 0 0 0 14.17 9zm-9.67 0H1.8a6.26 6.26 0 0 0 3.94 5.08 12.59 12.59 0 0 1-1.16-4.7l-.03-.38zm1.2-6.58-.12.05a6.26 6.26 0 0 0-3.83 5.03h2.75c.09-1.83.48-3.54 1.06-4.81zm2.25-.42c-.7 0-1.78 2.51-1.94 5.5h3.9c-.15-2.9-1.18-5.34-1.89-5.5h-.07zm2.28.43.03.05a12.95 12.95 0 0 1 1.15 5.02h2.75a6.28 6.28 0 0 0-3.93-5.07z">
                                                                            </path>
                                                                        </svg>
                                                                    </span>
                                                                </button>
                                                            </div> --}}
                                                        </div>
                                                        <!-- زر القائمة -->
                                                            <div class="menu-container">
                                                            <button id="menuToggle" class="menu-btn">
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" aria-hidden="true" role="presentation" focusable="false" style="display:block;fill:none;height:16px;width:16px;stroke:currentcolor;stroke-width:3;overflow:visible">
                                                                            <g fill="none">
                                                                                <path d="M2 16h28M2 24h28M2 8h28">
                                                                                </path>
                                                                            </g>
                                                                        </svg>
                                                            </button>
                                                            </div>

                                                            <!-- القائمة -->
                                                            <nav id="profileMenu" class="profile-menu hidden">
                                                            <ul>
                                                                <li class="menu-header">
                                                                <a href="#">
                                                                    <span>مركز المساعدة</span> <span>❓</span>
                                                                </a>
                                                                </li>
                                                                <hr />
                                                                <li>
                                                                <a href="#">
                                                                    <img src="{{ asset('assets/web/image/house.png') }}"  alt="icon" />
                                                                    <div>
                                                                    <strong> انضم كمعلن</strong>
                                                                    <p>من السهل بدء الاستضافة وربح دخل إضافي.</p>
                                                                    </div>
                                                                </a>
                                                                </li>
                                                                <hr />
                                                                <li><a href="#">إحالة معلن</a></li>
                                                                <hr />
                                                                <li><a href="#">العثور على معلن مشارك</a></li>
                                                                <hr />
                                                                <li><a href="{{ route('login') }}">تسجيل الدخول أو الاشتراك</a></li>
                                                            </ul>
                                                            </nav>

                                                    </nav>
                                                </header>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="pk1c6x6 atm_mk_1n9t6rb atm_9s_1txwivl atm_fc_1h6ojuz atm_vy_1osqo2v atm_wq_kb7nvz dir dir-rtl">
                                    </div>
                                    <div class="m1un5iz5 atm_tw_jp4btk__600n0r atm_tr_y1hnx5__600n0r atm_uc_18thpt6__1ftj7wx atm_tr_atftsr__kice6x dir dir-rtl">
     
                                        <main
                                            class="mhb0xmj atm_gq_189ypq0 atm_gz_1fgafaw__2ygr2h atm_h0_i3vgjb__2ygr2h atm_lk_3ladnm__2ygr2h atm_ll_fk2qd9__2ygr2h dir dir-rtl"
                                            id=site-content>
                                            @yield('content')
                                        </main>

                                        </div>
                                    {{-- <div data-pageslot=true
                                        class="c1yo0219 atm_9s_1txwivl_vmtskl atm_92_1yyfdc7_vmtskl atm_9s_1txwivl_9in345 atm_92_1yyfdc7_9in345 dir dir-rtl">
                                        <div style=display:contents></div>
                                    </div> --}}
                                </div>
                                {{-- <div
                                    class="cxnsl1q atm_j3_1osqo2v atm_mk_1n9t6rb atm_wq_115503r atm_vy_1osqo2v atm_6i_u29brm atm_fq_idpfg4 atm_r3_1h6ojuz atm_l8_197tx09 atm_vy_ixjv83__oggzyc atm_fq_1vi7ecw__oggzyc atm_6i_1wqb8tt__oggzyc atm_r3_1kw7nm4__oggzyc atm_l8_idpfg4__oggzyc dir dir-rtl">
                                </div> --}}
                            </div>
                            {{-- <div class="dprtsy3 atm_9s_glywfm g1rrwumj dir dir-rtl sf-hidden"></div> --}}
                        </div>
                    </div>
                </div>
                {{-- <div
                    class="a1hdtgic atm_3f_idpfg4 atm_7h_hxbz6r atm_7i_ysn8ba atm_e2_t94yts atm_ks_zryt35 atm_l8_idpfg4 atm_mk_stnw88 atm_vv_1q9ccgz atm_vy_t94yts atm_h3_1n1ank9 dir dir-rtl">
                    <div aria-live=polite aria-atomic=true></div>
                    <div aria-live=assertive aria-atomic=true></div>
                </div> --}}
            </div>
        </div>
    </div>
    {{-- <browser-font-size
        style=position:fixed;left:0px;top:0px;width:0px;height:0px;overflow:hidden;pointer-events:none;clip:rect(0px,0px,0px,0px);clip-path:inset(50%)><template
            shadowrootmode=closed><iframe sandbox="allow-popups allow-top-navigation-by-user-activation"
                srcdoc="<html><meta charset=utf-8><style>@supports (font:-apple-system-body) and (-webkit-touch-callout:default){html{font:-apple-system-body}}div{width:1rem;height:1rem}</style><meta name=referrer content=no-referrer><meta http-equiv=content-security-policy content=&quot;default-src 'none'; font-src 'self' data:; img-src 'self' data:; style-src 'unsafe-inline'; media-src 'self' data:; script-src 'unsafe-inline' data:; object-src 'self' data:; frame-src 'self' data:;&quot;><body><div></div>">
                </iframe></template>
            </browser-font-size> --}}



    <!-- Start Footer -->
    <div style="margin-top: 10%"
        class="s1wgxt7p atm_zmyqmw_1ulexfb atm_lcucu6_exct8b atm_lcucu6_1tcgj5g__kgj4qw atm_lcucu6_1tcgj5g__oggzyc atm_lcucu6_1vi7ecw__1v156lz atm_lcucu6_idpfg4__jx8car atm_1l7p0i1_69rp3d__jx8car atm_1l7p0i1_12mkxmp__1z0u2lb dir dir-rtl">
        <div data-pageslot=true
            class="c1yo0219 atm_9s_1txwivl_vmtskl atm_92_1yyfdc7_vmtskl atm_9s_1txwivl_9in345 atm_92_1yyfdc7_9in345 dir dir-rtl">
            <div style=display:contents>
                {{-- <div
                    class="c1dbtjd2 atm_26_116dmco atm_15z7bj2_116dmco atm_gz_1fgafaw__2ygr2h atm_h0_i3vgjb__2ygr2h atm_lk_3ladnm__2ygr2h atm_ll_fk2qd9__2ygr2h dir dir-rtl">
                    <div
                        class="cff48sj atm_j3_1371zjx atm_gw_1wugsn5 atm_lb_dnsvzo atm_lh_1665e3e atm_9s_1pqooae__w5e62l atm_dz_uslobp__w5e62l atm_dl_1tcgj5g__w5e62l atm_dg_cs5v99_wwm54o dir dir-rtl">
                        <div>
                            <h2
                                class="hifxi0b atm_c8_sz6sci atm_g3_17zsb9a atm_fr_kzfbxz atm_cs_10d11i2 atm_gq_1yuitx dir dir-rtl">
                                احصل على الإلهام للرحلات المستقبلية</h2>
                            <div id=seo-link-section-tabbed-dense-grid>
                                <div class="t1x55g9c atm_mk_h2mmj6 dir dir-rtl">
                                    <div class="t13ci49g atm_l1_1wugsn5 atm_lk_1fwxnve atm_ll_1fwxnve atm_gz_zt4szt atm_h0_zt4szt atm_p9_glywfm atm_9s_glywfm_14pyf7n dir dir-rtl"
                                        data-testid=tab-list-wrapper>
                                        <div class="t1a99pzb atm_9s_1txwivl atm_vv_1q9ccgz atm_ks_ewfl5b dir dir-rtl"
                                            role=tablist></div>
                                    </div>
                                    <div
                                        class="tnlo7wt atm_e2_t94yts atm_2d_rke8ap dir dir-rtl">
                                    </div><button type=button
                                        class="se7mw7h atm_tk_t94yts atm_e2_12am3vd atm_vy_14noui3 atm_9s_1txwivl atm_l8_idpfg4 atm_mk_stnw88 atm_3f_glywfm atm_2d_1j28jx2 atm_h_1h6ojuz atm_7l_hkljqm atm_vl_1mx9q2e sv22vx9 atm_fq_zt4szt atm_2g_uyk09u atm_fc_1y6m0gg dir dir-rtl"
                                        data-testid=scroll-back-button><svg
                                            xmlns=http://www.w3.org/2000/svg
                                            viewBox="0 0 32 32"
                                            aria-label="تمرير علامات التبويب إلى الخلف"
                                            role=img focusable=false
                                            style=display:block;fill:none;height:16px;width:16px;stroke:currentcolor;stroke-width:3;overflow:visible>
                                            <path fill=none
                                                d="m12 4 11.3 11.3a1 1 0 0 1 0 1.4L12 28">
                                            </path>
                                        </svg></button><button type=button
                                        class="se7mw7h atm_tk_t94yts atm_e2_12am3vd atm_vy_14noui3 atm_9s_1txwivl atm_l8_idpfg4 atm_mk_stnw88 atm_3f_glywfm atm_2d_1j28jx2 atm_h_1h6ojuz atm_7l_hkljqm atm_vl_1mx9q2e sd463ns atm_n3_zt4szt atm_2g_1u77sm2 atm_fc_esu3gu dir dir-rtl"
                                        data-testid=scroll-forward-button><svg
                                            xmlns=http://www.w3.org/2000/svg
                                            viewBox="0 0 32 32"
                                            aria-label="تمرير علامات التبويب إلى الأمام"
                                            role=img focusable=false
                                            style=display:block;fill:none;height:16px;width:16px;stroke:currentcolor;stroke-width:3;overflow:visible>
                                            <path fill=none
                                                d="M20 28 8.7 16.7a1 1 0 0 1 0-1.4L20 4">
                                            </path>
                                        </svg></button>
                                </div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
    <div data-pageslot=true
        class="c1yo0219 atm_9s_1txwivl_vmtskl atm_92_1yyfdc7_vmtskl atm_9s_1txwivl_9in345 atm_92_1yyfdc7_9in345 dir dir-rtl">
        <footer style="padding-left: 10px;padding-right: 10px;" class="ff6a337 atm_26_1s640os atm_gz_1fgafaw atm_h0_i3vgjb atm_lk_3ladnm atm_ll_fk2qd9 dir dir-rtl">
            <div class="csmcb5i atm_gw_1wugsn5 atm_j3_1vvhni0 atm_lk_1ph3nq8 atm_ll_1ph3nq8 atm_lk_n9wab5__1v156lz atm_ll_n9wab5__1v156lz atm_lk_dnsvzo__jx8car atm_ll_dnsvzo__jx8car dir dir-rtl">
                <div class="c1x7vv2s atm_dg_cs5v99 dir dir-rtl">
                    <span class="a8jt5op atm_3f_idpfg4 atm_7h_hxbz6r atm_7i_ysn8ba atm_e2_t94yts atm_ks_zryt35 atm_l8_idpfg4 atm_mk_stnw88 atm_vv_1q9ccgz atm_vy_t94yts dir dir-rtl">
                        <h2>تذييل الموقع</h2>
                    </span>
                    <div class="l1g2ukzz atm_9s_11p5wf0 atm_84_8tjzot atm_dz_xd6q80 atm_l8_7itjjg__oggzyc atm_dz_a394vb__oggzyc atm_l8_inmbpd__1v156lz atm_dz_1gmb2a1__1v156lz atm_l8_1gwji0s__jx8car atm_dz_11d8nb1__1z0u2lb dir dir-rtl">
                        <section class="se5ui3x atm_67_1vlbu9m atm_lb_1ph3nq8 atm_da_cbdd7d atm_67_idpfg4_13mkcot atm_67_idpfg4__oggzyc atm_lb_idpfg4__oggzyc atm_da_g31la2__oggzyc atm_da_x71zqm__1v156lz atm_da_1oo4mti__1z0u2lb dir dir-rtl">
                            <h3 class="trsc28b atm_gi_idpfg4 atm_7l_dezgoh atm_c8_km0zk7 atm_g3_18khvle atm_fr_1m9t47k atm_cs_10d11i2 atm_gq_8tjzot dir dir-rtl">
                                الدعم
                            </h3>
                            <ul class="l1qzr284 atm_gi_idpfg4 atm_l8_idpfg4 atm_gb_glywfm atm_9s_11p5wf0 atm_cx_8tjzot dir dir-rtl">
                                <li><a href="#/help/home?from=footer" class="footer_link">مركزالمساعدة</a></li>
                                <li><a href="#/against-discrimination" class="footer_link">مناهضةالتمييز</a></li>
                                <li><a href="#/accessibility" class="footer_link">دعم ذوي الاحتياجات</a></li>
                                <li><a href="#/help" class="footer_link">خيارات الإلغاء</a></li>
                                <li><a href="#/neighbors" class="footer_link">إبلاغ عن مخاوف في الحي</a></li>
                            </ul>
                        </section>
                        <section class="se5ui3x atm_67_1vlbu9m atm_lb_1ph3nq8 atm_da_cbdd7d atm_67_idpfg4_13mkcot atm_67_idpfg4__oggzyc atm_lb_idpfg4__oggzyc atm_da_g31la2__oggzyc atm_da_x71zqm__1v156lz atm_da_1oo4mti__1z0u2lb dir dir-rtl">
                            <h3 class="trsc28b atm_gi_idpfg4 atm_7l_dezgoh atm_c8_km0zk7 atm_g3_18khvle atm_fr_1m9t47k atm_cs_10d11i2 atm_gq_8tjzot dir dir-rtl">
                                الاعلانات</h3>
                            <ul class="l1qzr284 atm_gi_idpfg4 atm_l8_idpfg4 atm_gb_glywfm atm_9s_11p5wf0 atm_cx_8tjzot dir dir-rtl">
                                {{-- <li><a href="#" class="footer_link">اعرض بيتك على  mubashar</a></li>
                                <li><a href="#" class="footer_link">اعرض  تجربة السفر التي تقدمها على  mubashar</a></li>
                                <li><a href="#" class="footer_link">اعرض الخدمة التي تقدمها على  mubashar</a></li> --}}
                                <li><a href="" class="footer_link"> البيوت</a></li>
                                <li><a href="" class="footer_link"> السيارات</a></li>
                                {{-- <li><a href="#" class="footer_link">الاستضافة بمسؤولية</a></li>
                                <li><a href="#" class="footer_link">الانضمام إلى دورة مجانية عن الاستضافة</a></li>
                                <li><a href="#" class="footer_link">اعثر على مضيف مشارك</a></li> --}}
                            </ul>
                        </section>
                        <section  class="se5ui3x atm_67_1vlbu9m atm_lb_1ph3nq8 atm_da_cbdd7d atm_67_idpfg4_13mkcot atm_67_idpfg4__oggzyc atm_lb_idpfg4__oggzyc atm_da_g31la2__oggzyc atm_da_x71zqm__1v156lz atm_da_1oo4mti__1z0u2lb dir dir-rtl">
                            <h3 class="trsc28b atm_gi_idpfg4 atm_7l_dezgoh atm_c8_km0zk7 atm_g3_18khvle atm_fr_1m9t47k atm_cs_10d11i2 atm_gq_8tjzot dir dir-rtl"> mubashar</h3>
                            <ul
                                class="l1qzr284 atm_gi_idpfg4 atm_l8_idpfg4 atm_gb_glywfm atm_9s_11p5wf0 atm_cx_8tjzot dir dir-rtl">
                                <li>
                                    <p href=#/release >
                                                مباشر هو تطبيق حديث مصمّم ليسهّل على المستخدمين تأجير وبيع العقارات والسيارات بطريقة سريعة وآمنة واحترافية.
                                                يجمع التطبيق بين بساطة الاستخدام وقوة المزايا، ليقدّم تجربة مميزة لكل من المعلنين و المستأجرين/المشترين.
                                    <p>
                                </li>
                                {{-- <li><a href="#" class="footer_link">غرفة الأخبار</a></li>
                                <li><a href=#/careers class="footer_link">الوظائف</a></li>
                                <li><a href="#" class="footer_link">المستثمرون</a></li>
                                <li><a data-no-client-routing=true href=#/giftcards class="footer_link">بطاقات الهدايا</a></li>
                                <li><a href="#" class="footer_link"> mubashar.org للطوارئ</a></li> --}}
                            </ul>
                        </section>
                    </div>
                    <div class="f1n8x35d atm_lo_1ph3nq8 atm_le_1ph3nq8 atm_67_1w5adf1 dir dir-rtl">
                        <span class="a8jt5op atm_3f_idpfg4 atm_7h_hxbz6r atm_7i_ysn8ba atm_e2_t94yts atm_ks_zryt35 atm_l8_idpfg4 atm_mk_stnw88 atm_vv_1q9ccgz atm_vy_t94yts dir dir-rtl">قسم
                            أسفل الصفحة</span>
                        <section>
                            <div class="_1udzt2s sf-hidden"></div>
                            <div class="_1f9d3g6 sf-hidden"></div>
                            <div class=_wn5ilc>
                                <div class=_1lvew4p>
                                    <div class=_1fx0lfx>
                                        <div class=_yab4ip dir=ltr>© 2025  mubashar</div>
                                        <div class=_81igwj>
                                            {{-- <span class=_ovs8fp>
                                                <span class=_1bk5dva aria-hidden=true>·</span>
                                            </span>
                                            <span class="lv0dgul atm_c8_86zae atm_g3_1s00pb0 atm_fr_1h5ikn atm_9s_1o8liyq__1i7fo8i atm_9s_1nu9bjl_1trv8vf dir dir-rtl">
                                                <ol class="la1n7wt atm_gi_idpfg4 atm_l8_idpfg4 dir dir-rtl">
                                                    <li class="lfnpv3j atm_9s_1o8liyq_keqd55 dir dir-rtl">
                                                        <a href=#/terms/privacy_policy
                                                            class="l1ovpqvx atm_1he2i46_1k8pnbi_10saat9 atm_yxpdqi_1pv6nv4_10saat9 atm_1a0hdzc_w1h1e8_10saat9 atm_2bu6ew_929bqk_10saat9 atm_12oyo1u_73u7pn_10saat9 atm_fiaz40_1etamxe_10saat9 bewl01v atm_bx_1kw7nm4 atm_cd_1kw7nm4 atm_ci_1kw7nm4 atm_9j_tlke0l_1nos8r_uv4tnr atm_7l_1kw7nm4_1nos8r_uv4tnr atm_rd_8stvzk_1nos8r_uv4tnr atm_7l_1kw7nm4_pfnrn2 atm_rd_8stvzk_pfnrn2 c1w4n3ae atm_1s_glywfm atm_26_1j28jx2 atm_3f_idpfg4 atm_9j_tlke0l atm_gi_idpfg4 atm_l8_idpfg4 atm_vb_1wugsn5 atm_7l_1kw7nm4 atm_5j_yh40bf atm_r3_1kw7nm4 atm_mk_h2mmj6 atm_kd_glywfm atm_rd_glywfm atm_cs_6adqpa atm_c8_86zae atm_g3_1s00pb0 atm_fr_1h5ikn atm_9j_13gfvf7_1o5j5ji atm_rd_glywfm_1mj13j2_uv4tnr atm_7l_1he744i_v5whe7 atm_7l_1he744i_z5n1qr_uv4tnr atm_7l_1he744i_43xwow_uv4tnr atm_7l_1psja2f_4fughm_uv4tnr atm_rd_8stvzk_4fughm_uv4tnr atm_9j_13gfvf7_1cxuzpn_uv4tnr atm_3f_glywfm_jo46a5 atm_l8_idpfg4_jo46a5 atm_gi_idpfg4_jo46a5 atm_3f_glywfm_1icshfk atm_kd_glywfm_19774hq atm_7l_1v2u014_1w3cfyq atm_2d_9o8f4l_1w3cfyq atm_uc_1xdvyus_1w3cfyq atm_70_1syidmw_1w3cfyq atm_uc_glywfm_1w3cfyq_1rrf6b5 atm_7l_1v2u014_94ny3c atm_7l_1v2u014_196zkze atm_7l_1psja2f_1o5j5ji dir dir-rtl"
                                                            >الخصوصية
                                                        </a>
                                                        <span class="agiffpk dir dir-rtl">
                                                            <span class="syns96s atm_mj_glywfm atm_vb_glywfm atm_vv_1jtmq4 atm_lk_idpfg4 atm_ll_idpfg4 dir dir-rtl"
                                                                aria-hidden=true>
                                                                <span class=_1bk5dva aria-hidden=true>·</span>
                                                            </span>
                                                        </span>
                                                    </li>
                                                    <li class="lfnpv3j atm_9s_1o8liyq_keqd55 dir dir-rtl">
                                                        <span class="p1nuuvsc atm_9s_glywfm dir dir-rtl sf-hidden"></span>
                                                        <a href=#/terms
                                                            class="l1ovpqvx atm_1he2i46_1k8pnbi_10saat9 atm_yxpdqi_1pv6nv4_10saat9 atm_1a0hdzc_w1h1e8_10saat9 atm_2bu6ew_929bqk_10saat9 atm_12oyo1u_73u7pn_10saat9 atm_fiaz40_1etamxe_10saat9 bewl01v atm_bx_1kw7nm4 atm_cd_1kw7nm4 atm_ci_1kw7nm4 atm_9j_tlke0l_1nos8r_uv4tnr atm_7l_1kw7nm4_1nos8r_uv4tnr atm_rd_8stvzk_1nos8r_uv4tnr atm_7l_1kw7nm4_pfnrn2 atm_rd_8stvzk_pfnrn2 c1w4n3ae atm_1s_glywfm atm_26_1j28jx2 atm_3f_idpfg4 atm_9j_tlke0l atm_gi_idpfg4 atm_l8_idpfg4 atm_vb_1wugsn5 atm_7l_1kw7nm4 atm_5j_yh40bf atm_r3_1kw7nm4 atm_mk_h2mmj6 atm_kd_glywfm atm_rd_glywfm atm_cs_6adqpa atm_c8_86zae atm_g3_1s00pb0 atm_fr_1h5ikn atm_9j_13gfvf7_1o5j5ji atm_rd_glywfm_1mj13j2_uv4tnr atm_7l_1he744i_v5whe7 atm_7l_1he744i_z5n1qr_uv4tnr atm_7l_1he744i_43xwow_uv4tnr atm_7l_1psja2f_4fughm_uv4tnr atm_rd_8stvzk_4fughm_uv4tnr atm_9j_13gfvf7_1cxuzpn_uv4tnr atm_3f_glywfm_jo46a5 atm_l8_idpfg4_jo46a5 atm_gi_idpfg4_jo46a5 atm_3f_glywfm_1icshfk atm_kd_glywfm_19774hq atm_7l_1v2u014_1w3cfyq atm_2d_9o8f4l_1w3cfyq atm_uc_1xdvyus_1w3cfyq atm_70_1syidmw_1w3cfyq atm_uc_glywfm_1w3cfyq_1rrf6b5 atm_7l_1v2u014_94ny3c atm_7l_1v2u014_196zkze atm_7l_1psja2f_1o5j5ji dir dir-rtl"
                                                            >البنود
                                                        </a>
                                                        <span class="agiffpk dir dir-rtl">
                                                            <span class="syns96s atm_mj_glywfm atm_vb_glywfm atm_vv_1jtmq4 atm_lk_idpfg4 atm_ll_idpfg4 dir dir-rtl"
                                                                aria-hidden=true>
                                                                <span class=_1bk5dva aria-hidden=true>·</span>
                                                            </span>
                                                        </span>
                                                    </li>
                                                    <li
                                                        class="lfnpv3j atm_9s_1o8liyq_keqd55 dir dir-rtl">
                                                        <span class="p1nuuvsc atm_9s_glywfm dir dir-rtl sf-hidden"></span>
                                                        <a href=#/sitemaps/v2
                                                            class="l1ovpqvx atm_1he2i46_1k8pnbi_10saat9 atm_yxpdqi_1pv6nv4_10saat9 atm_1a0hdzc_w1h1e8_10saat9 atm_2bu6ew_929bqk_10saat9 atm_12oyo1u_73u7pn_10saat9 atm_fiaz40_1etamxe_10saat9 bewl01v atm_bx_1kw7nm4 atm_cd_1kw7nm4 atm_ci_1kw7nm4 atm_9j_tlke0l_1nos8r_uv4tnr atm_7l_1kw7nm4_1nos8r_uv4tnr atm_rd_8stvzk_1nos8r_uv4tnr atm_7l_1kw7nm4_pfnrn2 atm_rd_8stvzk_pfnrn2 c1w4n3ae atm_1s_glywfm atm_26_1j28jx2 atm_3f_idpfg4 atm_9j_tlke0l atm_gi_idpfg4 atm_l8_idpfg4 atm_vb_1wugsn5 atm_7l_1kw7nm4 atm_5j_yh40bf atm_r3_1kw7nm4 atm_mk_h2mmj6 atm_kd_glywfm atm_rd_glywfm atm_cs_6adqpa atm_c8_86zae atm_g3_1s00pb0 atm_fr_1h5ikn atm_9j_13gfvf7_1o5j5ji atm_rd_glywfm_1mj13j2_uv4tnr atm_7l_1he744i_v5whe7 atm_7l_1he744i_z5n1qr_uv4tnr atm_7l_1he744i_43xwow_uv4tnr atm_7l_1psja2f_4fughm_uv4tnr atm_rd_8stvzk_4fughm_uv4tnr atm_9j_13gfvf7_1cxuzpn_uv4tnr atm_3f_glywfm_jo46a5 atm_l8_idpfg4_jo46a5 atm_gi_idpfg4_jo46a5 atm_3f_glywfm_1icshfk atm_kd_glywfm_19774hq atm_7l_1v2u014_1w3cfyq atm_2d_9o8f4l_1w3cfyq atm_uc_1xdvyus_1w3cfyq atm_70_1syidmw_1w3cfyq atm_uc_glywfm_1w3cfyq_1rrf6b5 atm_7l_1v2u014_94ny3c atm_7l_1v2u014_196zkze atm_7l_1psja2f_1o5j5ji dir dir-rtl"
                                                            >خريطة
                                                            الموقع
                                                        </a>
                                                    </li>
                                                </ol>
                                            </span> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class=_jro6t0>
                                    <div class=_vrvung>
                                        <div class=_jro6t0>
                                            <span class=_7legec>
                                                <button
                                                    aria-label="اختيار اللغة"
                                                    type=button
                                                    class="l1ovpqvx atm_1he2i46_1k8pnbi_10saat9 atm_yxpdqi_1pv6nv4_10saat9 atm_1a0hdzc_w1h1e8_10saat9 atm_2bu6ew_929bqk_10saat9 atm_12oyo1u_73u7pn_10saat9 atm_fiaz40_1etamxe_10saat9 blxjh7d atm_9j_tlke0l atm_9s_1o8liyq atm_gi_idpfg4 atm_mk_h2mmj6 atm_r3_1h6ojuz atm_rd_glywfm atm_3f_uuagnh atm_70_5j5alw atm_vy_1wugsn5 atm_tl_1gw4zv3 atm_9j_13gfvf7_1o5j5ji c10409tp atm_bx_48h72j atm_cs_10d11i2 atm_26_1i7d4jj atm_20_13viflf atm_7l_1ca5zq3 atm_5j_96920c atm_4b_1oq6qme atm_6h_dpi2ty atm_66_nqa18y atm_kd_glywfm atm_jb_16cl52u atm_uc_1lizyuv atm_r2_1j28jx2 atm_1pgz0hy_t09oo2 atm_90hitl_ftgil2 atm_1artg4w_exct8b atm_q3c8am_ftgil2 atm_17k63hd_exct8b atm_16gn1vh_bremjp atm_1nv7vqx_qne844 atm_1ycj583_idpfg4 atm_bp5prx_1wugsn5 atm_pbz4zy_1j28jx2 atm_143zgh5_1ykuqvp atm_15vesau_1j28jx2 atm_jzguh3_1ykuqvp atm_ldn80t_1s640os atm_b9xxwi_1ykuqvp atm_114pxjm_1s640os atm_182m1vx_1ykuqvp atm_1h1macq_1j28jx2 atm_j7efc6_1gkufv3 atm_ksrr9c_13dujet atm_c8_86zae atm_g3_1s00pb0 atm_fr_1h5ikn atm_l8_1f10cpp atm_vz_1e032xh_wc6gzy atm_uc_1no41w5_wc6gzy atm_uc_glywfm__1rrf6b5 atm_kd_glywfm_1w3cfyq atm_uc_aaiy6o_1w3cfyq atm_4b_1r2f4og_1w3cfyq atm_26_1fudmwu_1w3cfyq atm_7l_1jopa2a_1w3cfyq atm_70_1c36325_1w3cfyq atm_3f_glywfm_e4a3ld atm_l8_idpfg4_e4a3ld atm_gi_idpfg4_e4a3ld atm_3f_glywfm_1r4qscq atm_kd_glywfm_6y7yyg atm_uc_glywfm_1w3cfyq_1rrf6b5 atm_4b_1ymcg8c_1nos8r_uv4tnr atm_26_asnl7k_1nos8r_uv4tnr atm_7l_1etjrq5_1nos8r_uv4tnr atm_tr_c3l1w2_z5n1qr_uv4tnr atm_4b_1cpdnk2_pd0br1_uv4tnr atm_26_zp0x24_pd0br1_uv4tnr atm_7l_1n4947f_pd0br1_uv4tnr atm_4b_13y81g2_4fughm_uv4tnr atm_26_zsif75_4fughm_uv4tnr atm_7l_3x6mlv_4fughm_uv4tnr atm_tr_glywfm_4fughm_uv4tnr atm_4b_1cpdnk2_csw3t1 atm_26_zp0x24_csw3t1 atm_7l_1n4947f_csw3t1 atm_tr_c3l1w2_csw3t1 atm_7l_1jopa2a_pfnrn2 atm_4b_13y81g2_1o5j5ji atm_26_zsif75_1o5j5ji atm_7l_3x6mlv_1o5j5ji atm_k4_kb7nvz_1o5j5ji atm_tr_glywfm_1o5j5ji atm_rd_f546ox_1nos8r atm_rd_f546ox_pfnrn2 atm_rd_f546ox_1xfbuyq dir dir-rtl"
                                                    style=--dls-button-or-anchor-width-px:78.46875;--dls-button-or-anchor-height-px:30>
                                                    <span data-button-content=true class="b19e0h4s atm_9s_1cw04bb atm_rd_1kw7nm4 atm_vz_kcpwjc atm_uc_kkvtv4 dir dir-rtl">
                                                        <span data-size=medium class="ct3xon4 atm_9s_116y0ak atm_vh_jp4btk atm_h_1h6ojuz atm_fc_1h6ojuz atm_cx_ftgil2 atm_mj_glywfm atm_cx_ftgil2_jwa8pe atm_cx_ftgil2_vwoy28 atm_cx_1y44olf_2n0w13 dir dir-rtl">
                                                            <svg
                                                                xmlns=http://www.w3.org/2000/svg
                                                                viewBox="0 0 16 16"
                                                                aria-hidden=true
                                                                role=presentation
                                                                focusable=false
                                                                style=display:block;height:16px;width:16px;fill:currentcolor>
                                                                <path
                                                                    d="M8 .25a7.77 7.77 0 0 1 7.75 7.78 7.75 7.75 0 0 1-7.52 7.72h-.25A7.75 7.75 0 0 1 .25 8.24v-.25A7.75 7.75 0 0 1 8 .25zm1.95 8.5h-3.9c.15 2.9 1.17 5.34 1.88 5.5H8c.68 0 1.72-2.37 1.93-5.23zm4.26 0h-2.76c-.09 1.96-.53 3.78-1.18 5.08A6.26 6.26 0 0 0 14.17 9zm-9.67 0H1.8a6.26 6.26 0 0 0 3.94 5.08 12.59 12.59 0 0 1-1.16-4.7l-.03-.38zm1.2-6.58-.12.05a6.26 6.26 0 0 0-3.83 5.03h2.75c.09-1.83.48-3.54 1.06-4.81zm2.25-.42c-.7 0-1.78 2.51-1.94 5.5h3.9c-.15-2.9-1.18-5.34-1.89-5.5h-.07zm2.28.43.03.05a12.95 12.95 0 0 1 1.15 5.02h2.75a6.28 6.28 0 0 0-3.93-5.07z">
                                                                </path>
                                                            </svg>
                                                            العربية
                                                        </span>
                                                    </span>
                                                </button>
                                            </span>
                                            <span
                                                class=_7legec><button
                                                    aria-label="اختيار العملة"
                                                    type=button
                                                    class="l1ovpqvx atm_1he2i46_1k8pnbi_10saat9 atm_yxpdqi_1pv6nv4_10saat9 atm_1a0hdzc_w1h1e8_10saat9 atm_2bu6ew_929bqk_10saat9 atm_12oyo1u_73u7pn_10saat9 atm_fiaz40_1etamxe_10saat9 blxjh7d atm_9j_tlke0l atm_9s_1o8liyq atm_gi_idpfg4 atm_mk_h2mmj6 atm_r3_1h6ojuz atm_rd_glywfm atm_3f_uuagnh atm_70_5j5alw atm_vy_1wugsn5 atm_tl_1gw4zv3 atm_9j_13gfvf7_1o5j5ji c10409tp atm_bx_48h72j atm_cs_10d11i2 atm_26_1i7d4jj atm_20_13viflf atm_7l_1ca5zq3 atm_5j_96920c atm_4b_1oq6qme atm_6h_dpi2ty atm_66_nqa18y atm_kd_glywfm atm_jb_16cl52u atm_uc_1lizyuv atm_r2_1j28jx2 atm_1pgz0hy_t09oo2 atm_90hitl_ftgil2 atm_1artg4w_exct8b atm_q3c8am_ftgil2 atm_17k63hd_exct8b atm_16gn1vh_bremjp atm_1nv7vqx_qne844 atm_1ycj583_idpfg4 atm_bp5prx_1wugsn5 atm_pbz4zy_1j28jx2 atm_143zgh5_1ykuqvp atm_15vesau_1j28jx2 atm_jzguh3_1ykuqvp atm_ldn80t_1s640os atm_b9xxwi_1ykuqvp atm_114pxjm_1s640os atm_182m1vx_1ykuqvp atm_1h1macq_1j28jx2 atm_j7efc6_1gkufv3 atm_ksrr9c_13dujet atm_c8_86zae atm_g3_1s00pb0 atm_fr_1h5ikn atm_l8_1f10cpp atm_vz_1e032xh_wc6gzy atm_uc_1no41w5_wc6gzy atm_uc_glywfm__1rrf6b5 atm_kd_glywfm_1w3cfyq atm_uc_aaiy6o_1w3cfyq atm_4b_1r2f4og_1w3cfyq atm_26_1fudmwu_1w3cfyq atm_7l_1jopa2a_1w3cfyq atm_70_1c36325_1w3cfyq atm_3f_glywfm_e4a3ld atm_l8_idpfg4_e4a3ld atm_gi_idpfg4_e4a3ld atm_3f_glywfm_1r4qscq atm_kd_glywfm_6y7yyg atm_uc_glywfm_1w3cfyq_1rrf6b5 atm_4b_1ymcg8c_1nos8r_uv4tnr atm_26_asnl7k_1nos8r_uv4tnr atm_7l_1etjrq5_1nos8r_uv4tnr atm_tr_c3l1w2_z5n1qr_uv4tnr atm_4b_1cpdnk2_pd0br1_uv4tnr atm_26_zp0x24_pd0br1_uv4tnr atm_7l_1n4947f_pd0br1_uv4tnr atm_4b_13y81g2_4fughm_uv4tnr atm_26_zsif75_4fughm_uv4tnr atm_7l_3x6mlv_4fughm_uv4tnr atm_tr_glywfm_4fughm_uv4tnr atm_4b_1cpdnk2_csw3t1 atm_26_zp0x24_csw3t1 atm_7l_1n4947f_csw3t1 atm_tr_c3l1w2_csw3t1 atm_7l_1jopa2a_pfnrn2 atm_4b_13y81g2_1o5j5ji atm_26_zsif75_1o5j5ji atm_7l_3x6mlv_1o5j5ji atm_k4_kb7nvz_1o5j5ji atm_tr_glywfm_1o5j5ji atm_rd_f546ox_1nos8r atm_rd_f546ox_pfnrn2 atm_rd_f546ox_1xfbuyq dir dir-rtl"
                                                    style=--dls-button-or-anchor-width-px:58.96875;--dls-button-or-anchor-height-px:30><span
                                                        data-button-content=true
                                                        class="b19e0h4s atm_9s_1cw04bb atm_rd_1kw7nm4 atm_vz_kcpwjc atm_uc_kkvtv4 dir dir-rtl">
                                                        <div class=_zd1hid>
                                                            <span>€</span><span>EUR</span>
                                                        </div>
                                                    </span></button></span></div>
                                    </div>
                                    <div class=_1gbtvfa>
                                        <ul class=_d2xvzy>
                                            <li class=_7legec><a
                                                    rel="noopener noreferrer"
                                                    target=_blank
                                                    aria-label="الانتقال إلى Facebook"
                                                    href="#"
                                                    class="l1ovpqvx atm_1he2i46_1k8pnbi_10saat9 atm_yxpdqi_1pv6nv4_10saat9 atm_1a0hdzc_w1h1e8_10saat9 atm_2bu6ew_929bqk_10saat9 atm_12oyo1u_73u7pn_10saat9 atm_fiaz40_1etamxe_10saat9 c15g6oyc atm_1s_glywfm atm_5j_1ssbidh atm_9j_tlke0l atm_tl_1gw4zv3 atm_9s_1o8liyq atm_mk_h2mmj6 atm_l8_idpfg4 atm_gi_idpfg4 atm_3f_glywfm atm_2d_v1pa1f atm_7l_lerloo atm_uc_19xs0gj atm_kd_glywfm atm_1i0qmk0_idpfg4 atm_teja2d_1j28jx2 atm_1pgqari_1ykuqvp atm_1sq3y97_1j28jx2 atm_2bdht_1ykuqvp atm_dscbz2_1j28jx2 atm_1lwh1x6_1ykuqvp atm_1crt5n3_1j28jx2 atm_1q1v3h9_1gkufv3 atm_1v02rxp_1j28jx2 atm_1ofeedh_1s640os atm_1fklkm6_1s640os atm_fa50ew_1j28jx2 atm_9y4brj_1j28jx2 atm_10zj5xa_1j28jx2 atm_pzdf76_1j28jx2 atm_1tv373o_1j28jx2 atm_1xmjjzz_1vi7ecw atm_nbjvyu_1vi7ecw atm_unmfjg_1skjq4 atm_kd_glywfm_1w3cfyq atm_3f_glywfm_e4a3ld atm_l8_idpfg4_e4a3ld atm_gi_idpfg4_e4a3ld atm_3f_glywfm_1r4qscq atm_kd_glywfm_6y7yyg atm_9j_13gfvf7_1o5j5ji atm_uc_glywfm__1rrf6b5 atm_4b_zpisrj_1rqz0hn_uv4tnr atm_7l_oonxzo_4fughm_uv4tnr atm_2d_13vagss_4fughm_uv4tnr atm_2d_1lbyi75_1r92pmq_uv4tnr atm_4b_7hps52_1r92pmq_uv4tnr atm_tr_8dwpus_1k46luq_uv4tnr atm_3f_glywfm_jo46a5 atm_l8_idpfg4_jo46a5 atm_gi_idpfg4_jo46a5 atm_3f_glywfm_1icshfk atm_kd_glywfm_19774hq atm_uc_aaiy6o_1w3cfyq atm_70_glywfm_1w3cfyq atm_uc_glywfm_1w3cfyq_1rrf6b5 atm_70_1wx36md_9xuho3 atm_4b_1ukl3ww_9xuho3 atm_6h_1tpdecz_9xuho3 atm_66_nqa18y_9xuho3 atm_uc_g9he8m_9xuho3 atm_4b_botz5_1ul2smo atm_tr_8dwpus_d9f5ny atm_7l_oonxzo_1o5j5ji atm_2d_13vagss_1o5j5ji atm_k4_uk3aii_1o5j5ji atm_2d_1lbyi75_154oz7f atm_4b_7hps52_154oz7f atm_2d_il29g1_vmtskl atm_20_d71y6t_vmtskl atm_4b_thxgdg_vmtskl atm_6h_1ihynmr_vmtskl atm_66_nqa18y_vmtskl atm_92_1yyfdc7_vmtskl atm_9s_1ulexfb_vmtskl atm_mk_stnw88_vmtskl atm_tk_1ssbidh_vmtskl atm_fq_1ssbidh_vmtskl atm_tr_pryxvc_vmtskl atm_vy_12k9wfs_vmtskl atm_e2_33f83m_vmtskl atm_5j_wqrmaf_vmtskl atm_2d_122qtur_1rqz0hn_uv4tnr atm_2d_122qtur_1ul2smo dir dir-rtl"
                                                    style=--dls-button-or-anchor-width-px:16;--dls-button-or-anchor-height-px:16><span
                                                        data-button-content=true
                                                        class="b1j95upq atm_mk_h2mmj6 atm_9s_1txwivl atm_h_1h6ojuz atm_fc_1h6ojuz atm_vz_at6eh2 atm_uc_82skwb dir dir-rtl"><svg
                                                            viewBox="0 0 32 32"
                                                            xmlns=http://www.w3.org/2000/svg
                                                            aria-hidden=true
                                                            role=presentation
                                                            focusable=false
                                                            style=display:block;height:16px;width:16px;fill:currentcolor>
                                                            <path
                                                                d="m15.9700599 1c-8.26766469 0-14.9700599 6.70239521-14.9700599 14.9700599 0 7.0203593 4.83353293 12.9113772 11.3538922 14.5293413v-9.954491h-3.08682633v-4.5748503h3.08682633v-1.9712575c0-5.09520959 2.305988-7.45688623 7.3083832-7.45688623.948503 0 2.58503.18622754 3.2544911.37185629v4.14670654c-.3532934-.0371257-.9670659-.0556886-1.7293414-.0556886-2.454491 0-3.402994.9299401-3.402994 3.3473054v1.6179641h4.8898204l-.8401198 4.5748503h-4.0497006v10.2856287c7.4125749-.8952096 13.1562875-7.2065868 13.1562875-14.860479-.0005988-8.26766469-6.702994-14.9700599-14.9706587-14.9700599z">
                                                            </path>
                                                        </svg></span></a>
                                            <li class=_7legec><a
                                                    rel="noopener noreferrer"
                                                    target=_blank
                                                    aria-label="الانتقال إلى Twitter"
                                                    href="#"
                                                    class="l1ovpqvx atm_1he2i46_1k8pnbi_10saat9 atm_yxpdqi_1pv6nv4_10saat9 atm_1a0hdzc_w1h1e8_10saat9 atm_2bu6ew_929bqk_10saat9 atm_12oyo1u_73u7pn_10saat9 atm_fiaz40_1etamxe_10saat9 c15g6oyc atm_1s_glywfm atm_5j_1ssbidh atm_9j_tlke0l atm_tl_1gw4zv3 atm_9s_1o8liyq atm_mk_h2mmj6 atm_l8_idpfg4 atm_gi_idpfg4 atm_3f_glywfm atm_2d_v1pa1f atm_7l_lerloo atm_uc_19xs0gj atm_kd_glywfm atm_1i0qmk0_idpfg4 atm_teja2d_1j28jx2 atm_1pgqari_1ykuqvp atm_1sq3y97_1j28jx2 atm_2bdht_1ykuqvp atm_dscbz2_1j28jx2 atm_1lwh1x6_1ykuqvp atm_1crt5n3_1j28jx2 atm_1q1v3h9_1gkufv3 atm_1v02rxp_1j28jx2 atm_1ofeedh_1s640os atm_1fklkm6_1s640os atm_fa50ew_1j28jx2 atm_9y4brj_1j28jx2 atm_10zj5xa_1j28jx2 atm_pzdf76_1j28jx2 atm_1tv373o_1j28jx2 atm_1xmjjzz_1vi7ecw atm_nbjvyu_1vi7ecw atm_unmfjg_1skjq4 atm_kd_glywfm_1w3cfyq atm_3f_glywfm_e4a3ld atm_l8_idpfg4_e4a3ld atm_gi_idpfg4_e4a3ld atm_3f_glywfm_1r4qscq atm_kd_glywfm_6y7yyg atm_9j_13gfvf7_1o5j5ji atm_uc_glywfm__1rrf6b5 atm_4b_zpisrj_1rqz0hn_uv4tnr atm_7l_oonxzo_4fughm_uv4tnr atm_2d_13vagss_4fughm_uv4tnr atm_2d_1lbyi75_1r92pmq_uv4tnr atm_4b_7hps52_1r92pmq_uv4tnr atm_tr_8dwpus_1k46luq_uv4tnr atm_3f_glywfm_jo46a5 atm_l8_idpfg4_jo46a5 atm_gi_idpfg4_jo46a5 atm_3f_glywfm_1icshfk atm_kd_glywfm_19774hq atm_uc_aaiy6o_1w3cfyq atm_70_glywfm_1w3cfyq atm_uc_glywfm_1w3cfyq_1rrf6b5 atm_70_1wx36md_9xuho3 atm_4b_1ukl3ww_9xuho3 atm_6h_1tpdecz_9xuho3 atm_66_nqa18y_9xuho3 atm_uc_g9he8m_9xuho3 atm_4b_botz5_1ul2smo atm_tr_8dwpus_d9f5ny atm_7l_oonxzo_1o5j5ji atm_2d_13vagss_1o5j5ji atm_k4_uk3aii_1o5j5ji atm_2d_1lbyi75_154oz7f atm_4b_7hps52_154oz7f atm_2d_il29g1_vmtskl atm_20_d71y6t_vmtskl atm_4b_thxgdg_vmtskl atm_6h_1ihynmr_vmtskl atm_66_nqa18y_vmtskl atm_92_1yyfdc7_vmtskl atm_9s_1ulexfb_vmtskl atm_mk_stnw88_vmtskl atm_tk_1ssbidh_vmtskl atm_fq_1ssbidh_vmtskl atm_tr_pryxvc_vmtskl atm_vy_12k9wfs_vmtskl atm_e2_33f83m_vmtskl atm_5j_wqrmaf_vmtskl atm_2d_122qtur_1rqz0hn_uv4tnr atm_2d_122qtur_1ul2smo dir dir-rtl"
                                                    style=--dls-button-or-anchor-width-px:16;--dls-button-or-anchor-height-px:16><span
                                                        data-button-content=true
                                                        class="b1j95upq atm_mk_h2mmj6 atm_9s_1txwivl atm_h_1h6ojuz atm_fc_1h6ojuz atm_vz_at6eh2 atm_uc_82skwb dir dir-rtl"><svg
                                                            viewBox="0 0 32 32"
                                                            xmlns=http://www.w3.org/2000/svg
                                                            aria-hidden=true
                                                            role=presentation
                                                            focusable=false
                                                            style=display:block;height:16px;width:16px;fill:currentcolor>
                                                            <path
                                                                d="m18.461198 13.6964303 10.9224206-12.6964303h-2.5882641l-9.4839364 11.024132-7.57479218-11.024132h-8.73662592l11.4545721 16.6704401-11.4545721 13.3141565h2.58841076l10.01528114-11.6418582 7.9995355 11.6418582h8.7366259l-11.879291-17.2881663zm-3.5451833 4.1208802-1.1605868-1.66-9.23437656-13.20879216h3.97564793l7.45224943 10.65991686 1.1605868 1.66 9.6870415 13.8562592h-3.9756479l-7.9049144-11.3067482z">
                                                            </path>
                                                        </svg></span></a>
                                            <li class=_7legec><a
                                                    rel="noopener noreferrer"
                                                    target=_blank
                                                    aria-label="الانتقال إلى Instagram"
                                                    href="#"
                                                    class="l1ovpqvx atm_1he2i46_1k8pnbi_10saat9 atm_yxpdqi_1pv6nv4_10saat9 atm_1a0hdzc_w1h1e8_10saat9 atm_2bu6ew_929bqk_10saat9 atm_12oyo1u_73u7pn_10saat9 atm_fiaz40_1etamxe_10saat9 c15g6oyc atm_1s_glywfm atm_5j_1ssbidh atm_9j_tlke0l atm_tl_1gw4zv3 atm_9s_1o8liyq atm_mk_h2mmj6 atm_l8_idpfg4 atm_gi_idpfg4 atm_3f_glywfm atm_2d_v1pa1f atm_7l_lerloo atm_uc_19xs0gj atm_kd_glywfm atm_1i0qmk0_idpfg4 atm_teja2d_1j28jx2 atm_1pgqari_1ykuqvp atm_1sq3y97_1j28jx2 atm_2bdht_1ykuqvp atm_dscbz2_1j28jx2 atm_1lwh1x6_1ykuqvp atm_1crt5n3_1j28jx2 atm_1q1v3h9_1gkufv3 atm_1v02rxp_1j28jx2 atm_1ofeedh_1s640os atm_1fklkm6_1s640os atm_fa50ew_1j28jx2 atm_9y4brj_1j28jx2 atm_10zj5xa_1j28jx2 atm_pzdf76_1j28jx2 atm_1tv373o_1j28jx2 atm_1xmjjzz_1vi7ecw atm_nbjvyu_1vi7ecw atm_unmfjg_1skjq4 atm_kd_glywfm_1w3cfyq atm_3f_glywfm_e4a3ld atm_l8_idpfg4_e4a3ld atm_gi_idpfg4_e4a3ld atm_3f_glywfm_1r4qscq atm_kd_glywfm_6y7yyg atm_9j_13gfvf7_1o5j5ji atm_uc_glywfm__1rrf6b5 atm_4b_zpisrj_1rqz0hn_uv4tnr atm_7l_oonxzo_4fughm_uv4tnr atm_2d_13vagss_4fughm_uv4tnr atm_2d_1lbyi75_1r92pmq_uv4tnr atm_4b_7hps52_1r92pmq_uv4tnr atm_tr_8dwpus_1k46luq_uv4tnr atm_3f_glywfm_jo46a5 atm_l8_idpfg4_jo46a5 atm_gi_idpfg4_jo46a5 atm_3f_glywfm_1icshfk atm_kd_glywfm_19774hq atm_uc_aaiy6o_1w3cfyq atm_70_glywfm_1w3cfyq atm_uc_glywfm_1w3cfyq_1rrf6b5 atm_70_1wx36md_9xuho3 atm_4b_1ukl3ww_9xuho3 atm_6h_1tpdecz_9xuho3 atm_66_nqa18y_9xuho3 atm_uc_g9he8m_9xuho3 atm_4b_botz5_1ul2smo atm_tr_8dwpus_d9f5ny atm_7l_oonxzo_1o5j5ji atm_2d_13vagss_1o5j5ji atm_k4_uk3aii_1o5j5ji atm_2d_1lbyi75_154oz7f atm_4b_7hps52_154oz7f atm_2d_il29g1_vmtskl atm_20_d71y6t_vmtskl atm_4b_thxgdg_vmtskl atm_6h_1ihynmr_vmtskl atm_66_nqa18y_vmtskl atm_92_1yyfdc7_vmtskl atm_9s_1ulexfb_vmtskl atm_mk_stnw88_vmtskl atm_tk_1ssbidh_vmtskl atm_fq_1ssbidh_vmtskl atm_tr_pryxvc_vmtskl atm_vy_12k9wfs_vmtskl atm_e2_33f83m_vmtskl atm_5j_wqrmaf_vmtskl atm_2d_122qtur_1rqz0hn_uv4tnr atm_2d_122qtur_1ul2smo dir dir-rtl"
                                                    style=--dls-button-or-anchor-width-px:16;--dls-button-or-anchor-height-px:16><span
                                                        data-button-content=true
                                                        class="b1j95upq atm_mk_h2mmj6 atm_9s_1txwivl atm_h_1h6ojuz atm_fc_1h6ojuz atm_vz_at6eh2 atm_uc_82skwb dir dir-rtl"><svg
                                                            viewBox="0 0 32 32"
                                                            xmlns=http://www.w3.org/2000/svg
                                                            aria-hidden=true
                                                            role=presentation
                                                            focusable=false
                                                            style=display:block;height:16px;width:16px;fill:currentcolor>
                                                            <path
                                                                d="m9.78762432 1.10490642c-1.596.0753-2.6859.33-3.6387.7044-.9861.3843-1.8219.9-2.6535 1.7346s-1.3437 1.671-1.7253 2.6586c-.3693.9549-.6195 2.0457-.69 3.6426-.0705 1.59689998-.0861 2.11019998-.0783 6.18359998s.0258 4.584.1032 6.1842c.0762 1.5957.33 2.6853.7044 3.6384.3849.9861.9 1.8216 1.7349 2.6535s1.6707 1.3428 2.6607 1.725c.954.3687 2.0451.6201 3.6417.69 1.59659998.0699 2.11049998.0861 6.18269998.0783s4.5849-.0258 6.1848-.1017 2.6838-.3315 3.6372-.7041c.9861-.3858 1.8222-.9 2.6535-1.7352s1.3431-1.6722 1.7244-2.6604c.3696-.954.6207-2.0451.69-3.6405.0699-1.6011.0864-2.1123.0786-6.1851s-.0261-4.5834-.102-6.18299998c-.0759-1.5996-.33-2.6859-.7041-3.6396-.3855-.9861-.9-1.821-1.7346-2.6535s-1.6722-1.344-2.6601-1.7244c-.9546-.3693-2.0451-.621-3.6417-.69s-2.1105-.0867-6.1842-.0789-4.5837.0252-6.18359998.1032m.1752 27.11639998c-1.4625-.0636-2.2566-.3066-2.7858-.51-.7008-.27-1.2-.5964-1.7274-1.1187s-.8514-1.0233-1.125-1.7226c-.2055-.5292-.453-1.3224-.5214-2.7849-.0744-1.5807-.09-2.0553-.0987-6.06s.0066-4.4787.0759-6.05999998c.0624-1.4613.3069-2.2563.51-2.7852.27-.7017.5952-1.2 1.1187-1.7271s1.023-.8517 1.7229-1.1253c.5286-.2064 1.3218-.4518 2.7837-.5214 1.58189998-.075 2.05589998-.09 6.05999998-.0987s4.4793.0063 6.0618.0759c1.4613.0636 2.2566.3057 2.7849.51.7011.27 1.2.5943 1.7271 1.1187s.852 1.0221 1.1256 1.7235c.2067.5271.4521 1.32.5211 2.7828.0753 1.58189998.0924 2.05619998.0996 6.05999998s-.0069 4.4793-.0762 6.06c-.0639 1.4625-.3063 2.2569-.51 2.7867-.27.7005-.5955 1.2-1.1193 1.7268s-1.0227.8514-1.7229 1.125c-.528.2061-1.3221.4521-2.7828.5217-1.5819.0744-2.0559.09-6.0615.0987s-4.4781-.0075-6.05999998-.0759m12.22799748-20.23829998c.0012175.72808507.4409323 1.38373514 1.114083 1.66118326s1.4471512.12204713 1.9610409-.39373063.6664512-1.2903429.3865363-1.96247162c-.2799148-.67212872-.937173-1.10943617-1.6652577-1.10798463-.9938786.00199-1.7980584.80912438-1.7964025 1.80300362m-13.89301175 8.03189998c.00841427 4.254 3.46321425 7.6947 7.71631425 7.6866143 4.2531-.0081143 7.6962-3.4626143 7.6881143-7.7166143-.0081143-4.254-3.4638143-7.69559998-7.7175143-7.68721533-4.2537.00841535-7.69499998 3.46381533-7.68691425 7.71721533m2.70180425-.0054c-.0054522-2.761471 2.2287325-5.0045146 4.9902035-5.0099904 2.761471-.0054558 5.0045175 2.228726 5.009997 4.990197.0054593 2.761471-2.2287195 5.0045204-4.9901905 5.0100045-1.3261582.0027764-2.5990901-.5214481-3.5386825-1.4573271s-1.4688535-2.2067251-1.4713275-3.532884">
                                                            </path>
                                                        </svg></span></a>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!-- End Footer -->

    <!-- Script -->
    <script src="{{ asset('assets/web/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/web/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/web/js/jquery.slick.min.js') }}"></script>
    <script src="{{ asset('assets/web/js/ripples.min.js') }}"></script>
    <script src="{{ asset('assets/web/js/odometer.js') }}"></script>
    <script src="{{ asset('assets/web/js/main.js') }}"></script>


    <script>
    const menuToggle = document.getElementById("menuToggle");
    const profileMenu = document.getElementById("profileMenu");


    menuToggle.addEventListener("click", function (e) {
        e.stopPropagation(); 
        profileMenu.classList.toggle("hidden");
    });


    document.addEventListener("click", function (e) {
        if (!profileMenu.contains(e.target) && !menuToggle.contains(e.target)) {
        profileMenu.classList.add("hidden");
        }
    });


    window.addEventListener("scroll", function () {
        profileMenu.classList.add("hidden");
    });
    </script>



    <script
        data-template-shadow-root>(() => { document.currentScript.remove(); 
        processNode(document); 
        function processNode(node) { node.querySelectorAll("template[shadowrootmode]").forEach(element => { let shadowRoot = element.parentElement.shadowRoot; 
        if (!shadowRoot) { try { shadowRoot = element.parentElement.attachShadow({ mode: element.getAttribute("shadowrootmode"), 
        delegatesFocus: element.getAttribute("shadowrootdelegatesfocus") != null, clonable: element.getAttribute("shadowrootclonable") != null, serializable: element.getAttribute("shadowrootserializable") != null }); 
        shadowRoot.innerHTML = element.innerHTML; element.remove() } catch (error) { } if (shadowRoot) { processNode(shadowRoot) } } }) } })()
    </script>
  </body>
</html>