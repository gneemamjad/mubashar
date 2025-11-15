@php
    use App\Models\User;
    use App\Models\Currency;
    app()->setLocale('ar');
@endphp

{{-- @extends('front.layouts.master-smallnav') --}}
@extends('web.layouts.master')

@section('title', 'Mubashar')


@section('content')

        <div style=--fixed-to-bottom__height:0px>
            <div>
                <div>
                    <div data-pageslot=true
                        class="c1yo0219 atm_9s_1txwivl_vmtskl atm_92_1yyfdc7_vmtskl atm_9s_1txwivl_9in345 atm_92_1yyfdc7_9in345 dir dir-rtl">
                        <div style=--gp-section-max-width:1120px
                            data-reactroot>
                            <div class=_v2335w>
                                <div style=--maxWidth:1120px
                                    class="plmw1e5 atm_e2_1osqo2v atm_gz_1wugsn5 atm_h0_1wugsn5 atm_vy_1osqo2v mq5rv0q atm_j3_1v7vjkn dir dir-rtl">
                                    <div data-plugin-in-point-id=TITLE_DEFAULT
                                        data-section-id=TITLE_DEFAULT>
                                        <div class=_1e9g34tc>
                                            <section>
                                                <div class=_1qquw5y>
                                                    <div class=_t0tx82>
                                                        <div
                                                            class=_14efb46>
                                                            <h1 tabindex=-1
                                                                class="hpipapi atm_7l_1kw7nm4 atm_c8_1x4eueo atm_cs_1kw7nm4 atm_g3_1kw7nm4 atm_gi_idpfg4 atm_l8_idpfg4 atm_kd_idpfg4_pfnrn2 i1pmzyw7 atm_9s_1nu9bjl dir dir-rtl"
                                                                elementtiming=LCP-target>
                                                                {{ $ad->title}}
                                                            </h1>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div  class=_1xbg2ts>
                                                            <div class=_4c6tf4>
                                                                <div class=_dswvvi>
                                                                    <button type=button
                                                                        class="l1ovpqvx atm_1he2i46_1k8pnbi_10saat9 atm_yxpdqi_1pv6nv4_10saat9 atm_1a0hdzc_w1h1e8_10saat9 atm_2bu6ew_929bqk_10saat9 atm_12oyo1u_73u7pn_10saat9 atm_fiaz40_1etamxe_10saat9 b1iktwwp atm_9j_tlke0l atm_9s_1o8liyq atm_gi_idpfg4 atm_mk_h2mmj6 atm_r3_1h6ojuz atm_70_5j5alw atm_vy_1wugsn5 atm_tl_1gw4zv3 atm_9j_13gfvf7_1o5j5ji cn6bjj0 atm_bx_48h72j atm_cs_10d11i2 atm_5j_t09oo2 atm_kd_glywfm atm_uc_1lizyuv atm_r2_1j28jx2 atm_c8_km0zk7 atm_g3_18khvle atm_fr_1m9t47k atm_jb_1yg2gu8 atm_3f_glywfm atm_26_1j28jx2 atm_7l_jt7fhx atm_rd_8stvzk atm_9xn0br_1wugsn5 atm_9tnf0v_1wugsn5 atm_7o60g0_1wugsn5 atm_gz_1bs0ed2 atm_h0_1bs0ed2 atm_l8_ftgil2 atm_uc_glywfm__1rrf6b5 atm_kd_glywfm_1w3cfyq atm_uc_aaiy6o_1w3cfyq atm_3f_glywfm_e4a3ld atm_l8_idpfg4_e4a3ld atm_gi_idpfg4_e4a3ld atm_3f_glywfm_1r4qscq atm_kd_glywfm_6y7yyg atm_uc_glywfm_1w3cfyq_1rrf6b5 atm_tr_18md41p_csw3t1 atm_k4_kb7nvz_1o5j5ji atm_3f_glywfm_1w3cfyq atm_26_zbnr2t_1w3cfyq atm_7l_jt7fhx_1w3cfyq atm_70_18bflhl_1w3cfyq atm_rd_8stvzk_pfnrn2 atm_3f_glywfm_1nos8r_uv4tnr atm_26_zbnr2t_1nos8r_uv4tnr atm_7l_177r58q_1nos8r_uv4tnr atm_rd_8stvzk_1nos8r_uv4tnr atm_3f_glywfm_4fughm_uv4tnr atm_26_1j28jx2_4fughm_uv4tnr atm_7l_9vytuy_4fughm_uv4tnr atm_3f_glywfm_csw3t1 atm_26_zbnr2t_csw3t1 atm_7l_177r58q_csw3t1 atm_3f_glywfm_1o5j5ji atm_26_1j28jx2_1o5j5ji atm_7l_9vytuy_1o5j5ji dir dir-rtl">
                                                                        <div  class=_5kaapu>
                                                                            <span class=_pog3hg>
                                                                                <svg
                                                                                    viewBox="0 0 32 32"
                                                                                    xmlns=http://www.w3.org/2000/svg
                                                                                    aria-hidden=true
                                                                                    role=presentation
                                                                                    focusable=false
                                                                                    style=display:block;fill:none;height:16px;width:16px;stroke:currentcolor;stroke-width:2;overflow:visible>
                                                                                    <path
                                                                                        d="m27 18v9c0 1.1046-.8954 2-2 2h-18c-1.10457 0-2-.8954-2-2v-9m11-15v21m-10-11 9.2929-9.29289c.3905-.39053 1.0237-.39053 1.4142 0l9.2929 9.29289"
                                                                                        fill=none>
                                                                                    </path>
                                                                                </svg>
                                                                            </span>المشاركة
                                                                        </div>
                                                                    </button>
                                                                </div>
                                                                <div>
                                                                    <!-- <button aria-label="حفظ في قائمة المختارات"
                                                                        data-testid=pdp-save-button-unsaved
                                                                        type=button
                                                                        class="l1ovpqvx atm_1he2i46_1k8pnbi_10saat9 atm_yxpdqi_1pv6nv4_10saat9 atm_1a0hdzc_w1h1e8_10saat9 atm_2bu6ew_929bqk_10saat9 atm_12oyo1u_73u7pn_10saat9 atm_fiaz40_1etamxe_10saat9 b1iktwwp atm_9j_tlke0l atm_9s_1o8liyq atm_gi_idpfg4 atm_mk_h2mmj6 atm_r3_1h6ojuz atm_70_5j5alw atm_vy_1wugsn5 atm_tl_1gw4zv3 atm_9j_13gfvf7_1o5j5ji cn6bjj0 atm_bx_48h72j atm_cs_10d11i2 atm_5j_t09oo2 atm_kd_glywfm atm_uc_1lizyuv atm_r2_1j28jx2 atm_c8_km0zk7 atm_g3_18khvle atm_fr_1m9t47k atm_jb_1yg2gu8 atm_3f_glywfm atm_26_1j28jx2 atm_7l_jt7fhx atm_rd_8stvzk atm_9xn0br_1wugsn5 atm_9tnf0v_1wugsn5 atm_7o60g0_1wugsn5 atm_gz_1bs0ed2 atm_h0_1bs0ed2 atm_l8_ftgil2 atm_uc_glywfm__1rrf6b5 atm_kd_glywfm_1w3cfyq atm_uc_aaiy6o_1w3cfyq atm_3f_glywfm_e4a3ld atm_l8_idpfg4_e4a3ld atm_gi_idpfg4_e4a3ld atm_3f_glywfm_1r4qscq atm_kd_glywfm_6y7yyg atm_uc_glywfm_1w3cfyq_1rrf6b5 atm_tr_18md41p_csw3t1 atm_k4_kb7nvz_1o5j5ji atm_3f_glywfm_1w3cfyq atm_26_zbnr2t_1w3cfyq atm_7l_jt7fhx_1w3cfyq atm_70_18bflhl_1w3cfyq atm_rd_8stvzk_pfnrn2 atm_3f_glywfm_1nos8r_uv4tnr atm_26_zbnr2t_1nos8r_uv4tnr atm_7l_177r58q_1nos8r_uv4tnr atm_rd_8stvzk_1nos8r_uv4tnr atm_3f_glywfm_4fughm_uv4tnr atm_26_1j28jx2_4fughm_uv4tnr atm_7l_9vytuy_4fughm_uv4tnr atm_3f_glywfm_csw3t1 atm_26_zbnr2t_csw3t1 atm_7l_177r58q_csw3t1 atm_3f_glywfm_1o5j5ji atm_26_1j28jx2_1o5j5ji atm_7l_9vytuy_1o5j5ji dir dir-rtl">
                                                                        <div aria-hidden=true
                                                                            class=_5kaapu>
                                                                            <span
                                                                                class=_pog3hg><svg
                                                                                    xmlns=http://www.w3.org/2000/svg
                                                                                    viewBox="0 0 32 32"
                                                                                    aria-hidden=true
                                                                                    role=presentation
                                                                                    focusable=false
                                                                                    style=display:block;fill:none;height:16px;width:16px;stroke:currentcolor;stroke-width:2;overflow:visible>
                                                                                    <path
                                                                                        d="M16 28c7-4.73 14-10 14-17a6.98 6.98 0 0 0-7-7c-1.8 0-3.58.68-4.95 2.05L16 8.1l-2.05-2.05a6.98 6.98 0 0 0-9.9 0A6.98 6.98 0 0 0 2 11c0 7 7 12.27 14 17z">
                                                                                    </path>
                                                                                </svg>
                                                                            </span>حفظ
                                                                        </div>
                                                                    </button> -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div data-pageslot=true
                        class="c1yo0219 atm_9s_1txwivl_vmtskl atm_92_1yyfdc7_vmtskl atm_9s_1txwivl_9in345 atm_92_1yyfdc7_9in345 dir dir-rtl">
                        <div style=--gp-section-max-width:1120px
                            data-reactroot>
                            <div class=_v2335w>
                                <div style=--maxWidth:1120px
                                    class="plmw1e5 atm_e2_1osqo2v atm_gz_1wugsn5 atm_h0_1wugsn5 atm_vy_1osqo2v mq5rv0q atm_j3_1v7vjkn dir dir-rtl">
                                    <div data-plugin-in-point-id=HERO_DEFAULT
                                        data-section-id=HERO_DEFAULT
                                        style=padding-top:24px>
                                        <!-- <div class= >
                                            <div class=_z80d2i>
                                                <div class=_mqdoygn>
                                                    <div
                                                        class=_168ht2w>
                                                        <div
                                                            class=_1f45hdx>
                                                            <div
                                                                class=_4h373l>
                                                                <div
                                                                    class=_13sj9hk>
                                                                    <div
                                                                        class=_100fji8>
                                                                        <div
                                                                            class="c1d4ry4s atm_e2_1osqo2v atm_mk_h2mmj6 atm_vy_1osqo2v atm_k4_18fjjhb_9bj8xt atm_ui_1wnasth_9bj8xt atm_2d_11x86a4_9in345 atm_6i_idpfg4_9in345 atm_92_1yyfdc7_9in345 atm_fq_idpfg4_9in345 atm_k4_idpfg4_9in345 atm_mj_glywfm_9in345 atm_mk_stnw88_9in345 atm_n3_idpfg4_9in345 atm_tk_idpfg4_9in345 atm_ui_ru3mkq_9in345 atm_uq_brmitn_9in345 atm_uv_kt56qc_9in345 atm_wq_cs5v99_9in345 dir dir-rtl">
                                                                            <button
                                                                                rel=nofollow
                                                                                aria-label="{{ $ad->title}}صورة 1"
                                                                                type=button
                                                                                class="_x65qker l1ovpqvx atm_1he2i46_1k8pnbi_10saat9 atm_yxpdqi_1pv6nv4_10saat9 atm_1a0hdzc_w1h1e8_10saat9 atm_2bu6ew_929bqk_10saat9 atm_12oyo1u_73u7pn_10saat9 atm_fiaz40_1etamxe_10saat9 dir dir-rtl">
                                                                                <div class="d5pn26n atm_9s_1o8liyq atm_vh_yfq0k3 atm_e2_88yjaz atm_vy_1r2rij0 atm_j6_t94yts b1see6r9 atm_2m_1qred53 atm_2s_mgnkw2 dir dir-rtl"
                                                                                    style=--dls-liteimage-height:100%;--dls-liteimage-width:100%;--dls-liteimage-background-image:url(data:image/png;base64,null);--dls-liteimage-background-size:cover>
                                                                                    <picture>
                                                                                        <img class="i33bb1j atm_e2_1osqo2v atm_vy_1osqo2v atm_mk_stnw88 ijnw5wu atm_jp_pyzg9w atm_jr_nyqth1 i1s295uf atm_vh_yfq0k3 dir dir-rtl"
                                                                                            aria-hidden=true
                                                                                            alt
                                                                                            elementtiming=LCP-target
                                                                                            fetchpriority=high
                                                                                            id=FMP-target
                                                                                            src="{{ getMediaUrl($ad->image, MEDIA_TYPES['image']) }}"
                                                                                            style=--dls-liteimage-object-fit:cover
                                                                                            srcset
                                                                                            sizes>
                                                                                    </picture>
                                                                                </div>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div
                                                                class=_1slhq9h>
                                                                <div
                                                                    class=_13sj9hk>
                                                                    <div
                                                                        class=_1l7oqbd>
                                                                        <div
                                                                            class=_100fji8>
                                                                            <div
                                                                                class="c1d4ry4s atm_e2_1osqo2v atm_mk_h2mmj6 atm_vy_1osqo2v atm_k4_18fjjhb_9bj8xt atm_ui_1wnasth_9bj8xt atm_2d_11x86a4_9in345 atm_6i_idpfg4_9in345 atm_92_1yyfdc7_9in345 atm_fq_idpfg4_9in345 atm_k4_idpfg4_9in345 atm_mj_glywfm_9in345 atm_mk_stnw88_9in345 atm_n3_idpfg4_9in345 atm_tk_idpfg4_9in345 atm_ui_ru3mkq_9in345 atm_uq_brmitn_9in345 atm_uv_kt56qc_9in345 atm_wq_cs5v99_9in345 dir dir-rtl">
                                                                                <button
                                                                                    rel=nofollow
                                                                                    aria-label="{{ $ad->title}} صورة 2"
                                                                                    type=button
                                                                                    class="_x65qker l1ovpqvx atm_1he2i46_1k8pnbi_10saat9 atm_yxpdqi_1pv6nv4_10saat9 atm_1a0hdzc_w1h1e8_10saat9 atm_2bu6ew_929bqk_10saat9 atm_12oyo1u_73u7pn_10saat9 atm_fiaz40_1etamxe_10saat9 dir dir-rtl">
                                                                                    <div class="d5pn26n atm_9s_1o8liyq atm_vh_yfq0k3 atm_e2_88yjaz atm_vy_1r2rij0 atm_j6_t94yts b1see6r9 atm_2m_1qred53 atm_2s_mgnkw2 dir dir-rtl"
                                                                                        style=--dls-liteimage-height:100%;--dls-liteimage-width:100%;--dls-liteimage-background-image:url(data:image/png;base64,null);--dls-liteimage-background-size:cover>
                                                                                        <picture>
                                                                                            <img class="i33bb1j atm_e2_1osqo2v atm_vy_1osqo2v atm_mk_stnw88 ijnw5wu atm_jp_pyzg9w atm_jr_nyqth1 i1s295uf atm_vh_yfq0k3 dir dir-rtl"
                                                                                                aria-hidden=true
                                                                                                alt
                                                                                                elementtiming=LCP-target
                                                                                                src="{{ getMediaUrl($ad->image, MEDIA_TYPES['image']) }}"
                                                                                                style=--dls-liteimage-object-fit:cover
                                                                                                srcset
                                                                                                sizes>
                                                                                        </picture>
                                                                                    </div>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        class=_924zz4g>
                                                                        <div
                                                                            class=_100fji8>
                                                                            <div
                                                                                class="c1d4ry4s atm_e2_1osqo2v atm_mk_h2mmj6 atm_vy_1osqo2v atm_k4_18fjjhb_9bj8xt atm_ui_1wnasth_9bj8xt atm_2d_11x86a4_9in345 atm_6i_idpfg4_9in345 atm_92_1yyfdc7_9in345 atm_fq_idpfg4_9in345 atm_k4_idpfg4_9in345 atm_mj_glywfm_9in345 atm_mk_stnw88_9in345 atm_n3_idpfg4_9in345 atm_tk_idpfg4_9in345 atm_ui_ru3mkq_9in345 atm_uq_brmitn_9in345 atm_uv_kt56qc_9in345 atm_wq_cs5v99_9in345 dir dir-rtl">
                                                                                <button
                                                                                    rel=nofollow
                                                                                    aria-label="{{ $ad->title}} صورة 3"
                                                                                    type=button
                                                                                    class="_x65qker l1ovpqvx atm_1he2i46_1k8pnbi_10saat9 atm_yxpdqi_1pv6nv4_10saat9 atm_1a0hdzc_w1h1e8_10saat9 atm_2bu6ew_929bqk_10saat9 atm_12oyo1u_73u7pn_10saat9 atm_fiaz40_1etamxe_10saat9 dir dir-rtl">
                                                                                    <div class="d5pn26n atm_9s_1o8liyq atm_vh_yfq0k3 atm_e2_88yjaz atm_vy_1r2rij0 atm_j6_t94yts b1see6r9 atm_2m_1qred53 atm_2s_mgnkw2 dir dir-rtl"
                                                                                        style=--dls-liteimage-height:100%;--dls-liteimage-width:100%;--dls-liteimage-background-image:url(data:image/png;base64,null);--dls-liteimage-background-size:cover>
                                                                                        <picture>
                                                                                            <img class="i33bb1j atm_e2_1osqo2v atm_vy_1osqo2v atm_mk_stnw88 ijnw5wu atm_jp_pyzg9w atm_jr_nyqth1 i1s295uf atm_vh_yfq0k3 dir dir-rtl"
                                                                                                aria-hidden=true
                                                                                                alt
                                                                                                elementtiming=LCP-target
                                                                                                src="{{ getMediaUrl($ad->image, MEDIA_TYPES['image']) }}"
                                                                                                style=--dls-liteimage-object-fit:cover
                                                                                                srcset
                                                                                                sizes>
                                                                                        </picture>
                                                                                    </div>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div
                                                                class=_ggc87y>
                                                                <div
                                                                    class=_13sj9hk>
                                                                    <div
                                                                        class=_1l7oqbd>
                                                                        <div
                                                                            class=_100fji8>
                                                                            <div
                                                                                class="c1d4ry4s atm_e2_1osqo2v atm_mk_h2mmj6 atm_vy_1osqo2v atm_k4_18fjjhb_9bj8xt atm_ui_1wnasth_9bj8xt atm_2d_11x86a4_9in345 atm_6i_idpfg4_9in345 atm_92_1yyfdc7_9in345 atm_fq_idpfg4_9in345 atm_k4_idpfg4_9in345 atm_mj_glywfm_9in345 atm_mk_stnw88_9in345 atm_n3_idpfg4_9in345 atm_tk_idpfg4_9in345 atm_ui_ru3mkq_9in345 atm_uq_brmitn_9in345 atm_uv_kt56qc_9in345 atm_wq_cs5v99_9in345 dir dir-rtl">
                                                                                <button
                                                                                    rel=nofollow
                                                                                    aria-label="{{ $ad->title}} صورة 4"
                                                                                    type=button
                                                                                    class="_x65qker l1ovpqvx atm_1he2i46_1k8pnbi_10saat9 atm_yxpdqi_1pv6nv4_10saat9 atm_1a0hdzc_w1h1e8_10saat9 atm_2bu6ew_929bqk_10saat9 atm_12oyo1u_73u7pn_10saat9 atm_fiaz40_1etamxe_10saat9 dir dir-rtl">
                                                                                    <div class="d5pn26n atm_9s_1o8liyq atm_vh_yfq0k3 atm_e2_88yjaz atm_vy_1r2rij0 atm_j6_t94yts b1see6r9 atm_2m_1qred53 atm_2s_mgnkw2 dir dir-rtl"
                                                                                        style=--dls-liteimage-height:100%;--dls-liteimage-width:100%;--dls-liteimage-background-image:url(data:image/png;base64,null);--dls-liteimage-background-size:cover>
                                                                                        <picture>
                                                                                            <img class="i33bb1j atm_e2_1osqo2v atm_vy_1osqo2v atm_mk_stnw88 ijnw5wu atm_jp_pyzg9w atm_jr_nyqth1 i1s295uf atm_vh_yfq0k3 dir dir-rtl"
                                                                                                aria-hidden=true
                                                                                                alt
                                                                                                elementtiming=LCP-target
                                                                                                src="{{ getMediaUrl($ad->image, MEDIA_TYPES['image']) }}"
                                                                                                style=--dls-liteimage-object-fit:cover
                                                                                                srcset
                                                                                                sizes>
                                                                                        </picture>
                                                                                    </div>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        class=_924zz4g>
                                                                        <div
                                                                            class=_100fji8>
                                                                            <div
                                                                                class="c1d4ry4s atm_e2_1osqo2v atm_mk_h2mmj6 atm_vy_1osqo2v atm_k4_18fjjhb_9bj8xt atm_ui_1wnasth_9bj8xt atm_2d_11x86a4_9in345 atm_6i_idpfg4_9in345 atm_92_1yyfdc7_9in345 atm_fq_idpfg4_9in345 atm_k4_idpfg4_9in345 atm_mj_glywfm_9in345 atm_mk_stnw88_9in345 atm_n3_idpfg4_9in345 atm_tk_idpfg4_9in345 atm_ui_ru3mkq_9in345 atm_uq_brmitn_9in345 atm_uv_kt56qc_9in345 atm_wq_cs5v99_9in345 dir dir-rtl">
                                                                                <button
                                                                                    rel=nofollow
                                                                                    aria-label="{{ $ad->title}} صورة 5"
                                                                                    type=button
                                                                                    class="_x65qker l1ovpqvx atm_1he2i46_1k8pnbi_10saat9 atm_yxpdqi_1pv6nv4_10saat9 atm_1a0hdzc_w1h1e8_10saat9 atm_2bu6ew_929bqk_10saat9 atm_12oyo1u_73u7pn_10saat9 atm_fiaz40_1etamxe_10saat9 dir dir-rtl">
                                                                                    <div class="d5pn26n atm_9s_1o8liyq atm_vh_yfq0k3 atm_e2_88yjaz atm_vy_1r2rij0 atm_j6_t94yts b1see6r9 atm_2m_1qred53 atm_2s_mgnkw2 dir dir-rtl"
                                                                                        style=--dls-liteimage-height:100%;--dls-liteimage-width:100%;--dls-liteimage-background-image:url(data:image/png;base64,null);--dls-liteimage-background-size:cover>
                                                                                        <picture>
                                                                                            <img class="i33bb1j atm_e2_1osqo2v atm_vy_1osqo2v atm_mk_stnw88 ijnw5wu atm_jp_pyzg9w atm_jr_nyqth1 i1s295uf atm_vh_yfq0k3 dir dir-rtl"
                                                                                                aria-hidden=true
                                                                                                alt
                                                                                                elementtiming=LCP-target
                                                                                                src="{{ getMediaUrl($ad->image, MEDIA_TYPES['image']) }}"
                                                                                                style=--dls-liteimage-object-fit:cover
                                                                                                srcset
                                                                                                sizes>
                                                                                        </picture>
                                                                                    </div>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div></div>
                                        </div> -->
                                        <div style="display:flex; gap:10px; direction:rtl;">
                                            {{-- الصورة الأساسية الكبيرة --}}
                                            @if(isset($ad->image))
                                                <div style="flex:1;">
                                                    <img src="{{ getMediaUrl($ad->image, MEDIA_TYPES['image']) }}"
                                                        alt="{{ $ad->title }} صورة 1"
                                                        style="width:100%; height:400px; object-fit:cover; border-radius:8px;" />
                                                </div>
                                            @endif

                                            {{-- الصور الجانبية --}}
                                            <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; flex:0.7; position:relative;">
                                                @foreach($ad->media->take(4) as $index => $image)
                                                    @if($loop->last && $ad->media->count() > 4)
                                                        <div style="position:relative; cursor:pointer;" onclick="openGallery( {{ $index+1 }} )">
                                                            <img src="{{ getMediaUrl($image->name, MEDIA_TYPES['image']) }}"
                                                                alt="{{ $ad->title }} صورة {{ $index + 2 }}"
                                                                style="width:100%; height:190px; object-fit:cover; border-radius:6px; filter:brightness(70%);" />
                                                            <span style="position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); color:white; font-size:24px; font-weight:bold;">
                                                                +{{ $ad->media->count() - 4 }}
                                                            </span>
                                                        </div>
                                                    @else
                                                        <img src="{{ getMediaUrl($image->name, MEDIA_TYPES['image']) }}"
                                                            alt="{{ $ad->title }} صورة {{ $index + 2 }}"
                                                            style="width:100%; height:190px; object-fit:cover; border-radius:6px; cursor:pointer;" 
                                                            onclick="openGallery({{ $index+1 }})" />
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class=_1ywxnzu9>
                    <div class=_v2335w>
                        <div class="plmw1e5 atm_e2_1osqo2v atm_gz_1wugsn5 atm_h0_1wugsn5 atm_vy_1osqo2v mq5rv0q atm_j3_1v7vjkn dir dir-rtl"
                            style=--maxWidth:1120px>
                            <div class=_dmn8hc>
                                <div data-pageslot=true
                                    class="c1yo0219 atm_9s_1txwivl_vmtskl atm_92_1yyfdc7_vmtskl atm_9s_1txwivl_9in345 atm_92_1yyfdc7_9in345 dir dir-rtl">
                                    <div data-plugin-in-point-id=NAV_DEFAULT
                                        data-section-id=NAV_DEFAULT
                                        style=display:contents
                                        class=sf-hidden></div>
                                </div>
                                <div data-pageslot=true
                                    class="c1yo0219 atm_9s_1txwivl_vmtskl atm_92_1yyfdc7_vmtskl atm_9s_1txwivl_9in345 atm_92_1yyfdc7_9in345 dir dir-rtl sf-hidden">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div data-pageslot=true
                    class="c1yo0219 atm_9s_1txwivl_vmtskl atm_92_1yyfdc7_vmtskl atm_9s_1txwivl_9in345 atm_92_1yyfdc7_9in345 dir dir-rtl">
                    <div class=_cuv1re data-reactroot>
                        <div class=_zzgou4n>
                            <div>
                                <div
                                    style=--gp-section-max-width:1120px>
                                    <div data-plugin-in-point-id=OVERVIEW_DEFAULT_V2
                                        data-section-id=OVERVIEW_DEFAULT_V2
                                        style=padding-top:32px;padding-bottom:32px>
                                        <div data-pageslot=true
                                            class="c1yo0219 atm_9s_1txwivl_vmtskl atm_92_1yyfdc7_vmtskl atm_9s_1txwivl_9in345 atm_92_1yyfdc7_9in345 dir dir-rtl">
                                            <div
                                                style=display:contents>
                                                <section>
                                                    <div
                                                        class="t1kjrihn atm_c8_2x1prs atm_g3_1jbyh58 atm_fr_11a07z3 atm_cs_10d11i2 atm_c8_sz6sci__oggzyc atm_g3_17zsb9a__oggzyc atm_fr_kzfbxz__oggzyc dir dir-rtl">
                                                        <h2 tabindex=-1
                                                            class="hpipapi atm_7l_1kw7nm4 atm_c8_1x4eueo atm_cs_1kw7nm4 atm_g3_1kw7nm4 atm_gi_idpfg4 atm_l8_idpfg4 atm_kd_idpfg4_pfnrn2 dir dir-rtl"
                                                            elementtiming=LCP-target>
                                                            {{ $ad->title}}
                                                        </h2>
                                                    </div>
                                                    <div
                                                        class="ok4wssy atm_c8_km0zk7 atm_g3_18khvle atm_fr_1m9t47k atm_h3_1y44olf atm_c8_2x1prs__oggzyc atm_g3_1jbyh58__oggzyc atm_fr_11a07z3__oggzyc dir dir-rtl">
                                                        <ol class="lgx66tx atm_gi_idpfg4 atm_l8_idpfg4 dir dir-rtl">
                                                            <li class="l7n4lsf atm_9s_1o8liyq_keqd55 dir dir-rtl">
                                                                {!! $ad->description !!}
                                                            </li>
                                                        </ol>
                                                    </div>
                                                </section>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div
                                    style=--gp-section-max-width:1120px>
                                    <div data-plugin-in-point-id=HOST_OVERVIEW_DEFAULT
                                        data-section-id=HOST_OVERVIEW_DEFAULT
                                        style=padding-top:24px;padding-bottom:24px>
                                        <div data-pageslot=true
                                            class="c1yo0219 atm_9s_1txwivl_vmtskl atm_92_1yyfdc7_vmtskl atm_9s_1txwivl_9in345 atm_92_1yyfdc7_9in345 dir dir-rtl">
                                            <div
                                                style=display:contents>
                                                <div
                                                    class="cm0tib6 atm_9s_1txwivl atm_cx_exct8b atm_cx_1tcgj5g__oggzyc dir dir-rtl">
                                                    <div class=_e7hn5
                                                        style=height:40px;width:40px>
                                                        <button
                                                            aria-label="Dominique مضيف متميّز. اعرف المزيد عن Dominique."
                                                            type=button
                                                            class="_kh3jnmd l1ovpqvx atm_1he2i46_1k8pnbi_10saat9 atm_yxpdqi_1pv6nv4_10saat9 atm_1a0hdzc_w1h1e8_10saat9 atm_2bu6ew_929bqk_10saat9 atm_12oyo1u_73u7pn_10saat9 atm_fiaz40_1etamxe_10saat9 dir dir-rtl">
                                                            <div class=_1c81x67
                                                                style=height:40px;width:40px;border-radius:50%>
                                                                <div class="d5pn26n atm_9s_1o8liyq atm_vh_yfq0k3 atm_e2_88yjaz atm_vy_1r2rij0 atm_j6_t94yts b1see6r9 atm_2m_1qred53 atm_2s_mgnkw2 dir dir-rtl"
                                                                    role=presentation
                                                                    aria-hidden=true
                                                                    style=--dls-liteimage-height:100%;--dls-liteimage-width:100%;--dls-liteimage-background-image:url(data:image/png;base64,null);--dls-liteimage-background-size:cover>
                                                                    <img class="i17a04ne atm_e2_1osqo2v atm_vy_1osqo2v atm_mk_pfqszd ijnw5wu atm_jp_pyzg9w atm_jr_nyqth1 i1s295uf atm_vh_yfq0k3 dir dir-rtl"
                                                                        aria-hidden=true
                                                                        alt="صورة الملف الشخصي للضيف"
                                                                        decoding=async
                                                                        elementtiming=LCP-target
                                                                        src='data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="240" height="240"><rect fill-opacity="0"/></svg>'
                                                                        data-original-uri="https://a0.muscache.com/im/pictures/user/User-40554294/original/b7cccf3e-53dd-46ec-9362-f74bb42ecfad.jpeg?im_w=240"
                                                                        style="--dls-liteimage-object-fit:cover;background-blend-mode:normal!important;background-clip:content-box!important;background-position:50% 50%!important;background-color:rgba(0,0,0,0)!important;background-image:var(--sf-img-18)!important;background-size:cover!important;background-origin:content-box!important;background-repeat:no-repeat!important">
                                                                </div>
                                                            </div>
                                                        </button>
                                                        <div
                                                            class="b1pxe1a4 atm_mk_stnw88 atm_6i_12gsa0d atm_n3_myb0kj dir dir-rtl">
                                                            <svg xmlns=http://www.w3.org/2000/svg
                                                                viewBox="0 0 12 14"
                                                                aria-hidden=true
                                                                role=presentation
                                                                focusable=false
                                                                style=display:block;height:20px;width:20px>
                                                                <lineargradient
                                                                    id=a
                                                                    x1=8.5%
                                                                    x2=92.18%
                                                                    y1=17.16%
                                                                    y2=17.16%>
                                                                    <stop
                                                                        offset=0
                                                                        stop-color=#e61e4d>
                                                                    </stop>
                                                                    <stop
                                                                        offset=.5
                                                                        stop-color=#e31c5f>
                                                                    </stop>
                                                                    <stop
                                                                        offset=1
                                                                        stop-color=#d70466>
                                                                    </stop>
                                                                </lineargradient>
                                                                <path
                                                                    fill=#fff
                                                                    d="M9.93 0c.88 0 1.6.67 1.66 1.52l.01.15v2.15c0 .54-.26 1.05-.7 1.36l-.13.08-3.73 2.17a3.4 3.4 0 1 1-2.48 0L.83 5.26A1.67 1.67 0 0 1 0 3.96L0 3.82V1.67C0 .79.67.07 1.52 0L1.67 0z">
                                                                </path>
                                                                <path
                                                                    fill=url(#a)
                                                                    d="M5.8 8.2a2.4 2.4 0 0 0-.16 4.8h.32a2.4 2.4 0 0 0-.16-4.8zM9.93 1H1.67a.67.67 0 0 0-.66.57l-.01.1v2.15c0 .2.1.39.25.52l.08.05L5.46 6.8c.1.06.2.09.29.1h.1l.1-.02.1-.03.09-.05 4.13-2.4c.17-.1.3-.29.32-.48l.01-.1V1.67a.67.67 0 0 0-.57-.66z">
                                                                </path>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="t1l7gi0l atm_9s_1txwivl atm_ar_1bp4okc atm_fc_1h6ojuz atm_cx_1y44olf dir dir-rtl">
                                                        <div
                                                            class="t1lpv951 atm_c8_2x1prs atm_g3_1jbyh58 atm_fr_11a07z3 atm_cs_10d11i2 dir dir-rtl">
                                                            {{$ad->owner->first_name}} {{$ad->owner->last_name}}
                                                        </div>
                                                        <div
                                                            class="s121tj5m atm_c8_km0zk7 atm_g3_18khvle atm_fr_1m9t47k atm_7l_1esdqks dir dir-rtl">
                                                            <ol
                                                                class="lgx66tx atm_gi_idpfg4 atm_l8_idpfg4 dir dir-rtl">
                                                                <li
                                                                    class="l7n4lsf atm_9s_1o8liyq_keqd55 dir dir-rtl">
                                                                    {{User::USERTYPE[$ad->owner->user_type] ?? ''}}
                                                                    <span class="axjq0r atm_9s_glywfm dir dir-rtl sf-hidden"></span>
                                                                </li>
                                                            </ol>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @php
                                $key = array_search('Static', array_column($ad->attributes, 'name'));
                                $keyFe = array_search('Feture', array_column($ad->attributes, 'name'));
                                @endphp
                                @if($key)
                                <div data-pageslot=true
                                    class="c1yo0219 atm_9s_1txwivl_vmtskl atm_92_1yyfdc7_vmtskl atm_9s_1txwivl_9in345 atm_92_1yyfdc7_9in345 dir dir-rtl">
                                    <div
                                        style=--gp-section-max-width:1120px>
                                        <div class=_npr0qi
                                            style=border-top-color:rgb(221,221,221)>
                                        </div>
                                        <div data-plugin-in-point-id=HIGHLIGHTS_DEFAULT
                                            data-section-id=HIGHLIGHTS_DEFAULT
                                            style=padding-top:32px;padding-bottom:32px>
                                            <section>
                                                <div
                                                    class="a8jt5op atm_3f_idpfg4 atm_7h_hxbz6r atm_7i_ysn8ba atm_e2_t94yts atm_ks_zryt35 atm_l8_idpfg4 atm_mk_stnw88 atm_vv_1q9ccgz atm_vy_t94yts dir dir-rtl">
                                                    <h2 tabindex=-1
                                                        class="hpipapi atm_7l_1kw7nm4 atm_c8_1x4eueo atm_cs_1kw7nm4 atm_g3_1kw7nm4 atm_gi_idpfg4 atm_l8_idpfg4 atm_kd_idpfg4_pfnrn2 dir dir-rtl"
                                                        elementtiming=LCP-target>
                                                        النقاط
                                                        البارزة
                                                        للمسكن</h2>
                                                </div>
                                                <div
                                                    class="i1jq8c6w atm_9s_1txwivl atm_ar_1bp4okc atm_cx_1tcgj5g dir dir-rtl">
                                                    @foreach($ad->attributes[$key]['attributes'] as $attr)
                                                    <div>
                                                        <div
                                                            class=_wlu9uw>
                                                            <!-- <div
                                                                class=_1wiczqm>
                                                                <svg xmlns=http://www.w3.org/2000/svg
                                                                    viewBox="0 0 32 32"
                                                                    aria-hidden=true
                                                                    role=presentation
                                                                    focusable=false
                                                                    style=display:block;height:24px;width:24px;fill:currentcolor>
                                                                    <path
                                                                        d="M17 6a2 2 0 0 1 2 1.85v8.91l.24.24H24v-3h-3a1 1 0 0 1-.98-1.2l.03-.12 2-6a1 1 0 0 1 .83-.67L23 6h4a1 1 0 0 1 .9.58l.05.1 2 6a1 1 0 0 1-.83 1.31L29 14h-3v3h5a1 1 0 0 1 1 .88V30h-2v-3H20v3h-2v-3H2v3H0V19a3 3 0 0 1 1-2.24V8a2 2 0 0 1 1.85-2H3zm13 13H20v6h10zm-13-1H3a1 1 0 0 0-1 .88V25h16v-6a1 1 0 0 0-.77-.97l-.11-.02zm8 3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zM17 8H3v8h2v-3a2 2 0 0 1 1.85-2H13a2 2 0 0 1 2 1.85V16h2zm-4 5H7v3h6zm13.28-5h-2.56l-1.33 4h5.22z">
                                                                    </path>
                                                                </svg>
                                                            </div> -->
                                                            <div>
                                                                <div
                                                                    class=_120scdtp>
                                                                    <h3 tabindex=-1
                                                                        class="hpipapi atm_7l_1kw7nm4 atm_c8_1x4eueo atm_cs_1kw7nm4 atm_g3_1kw7nm4 atm_gi_idpfg4 atm_l8_idpfg4 atm_kd_idpfg4_pfnrn2 dir dir-rtl"
                                                                        elementtiming=LCP-target>
                                                                        {{$attr->key}}
                                                                    </h3>
                                                                </div>
                                                                <div
                                                                    class=_1hwkgn6>
                                                                    {{$attr->value}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div data-pageslot=true
                                    class="c1yo0219 atm_9s_1txwivl_vmtskl atm_92_1yyfdc7_vmtskl atm_9s_1txwivl_9in345 atm_92_1yyfdc7_9in345 dir dir-rtl">
                                    <div
                                        style=--gp-section-max-width:1120px>
                                        <div class=_npr0qi
                                            style=border-top-color:rgb(221,221,221)>
                                        </div>
                                        <div data-plugin-in-point-id=AMENITIES_DEFAULT
                                            data-section-id=AMENITIES_DEFAULT
                                            style=padding-top:48px;padding-bottom:48px>
                                            <section>
                                                <div class="s14u3lzn atm_le_74f3fj atm_le_8opf4g__oggzyc atm_le_dm248g__qky54b dir dir-rtl"
                                                    style=--spacingBottom:3>
                                                    <div
                                                        class="t5p7tdn atm_7l_dezgoh atm_bx_48h72j atm_cs_10d11i2 atm_c8_sz6sci atm_g3_17zsb9a atm_fr_kzfbxz dir dir-rtl">
                                                        <h2 tabindex=-1
                                                            class="hpipapi atm_7l_1kw7nm4 atm_c8_1x4eueo atm_cs_1kw7nm4 atm_g3_1kw7nm4 atm_gi_idpfg4 atm_l8_idpfg4 atm_kd_idpfg4_pfnrn2 dir dir-rtl"
                                                            elementtiming=LCP-target>
                                                            ما يقدمه
                                                            هذا
                                                            المسكن
                                                        </h2>
                                                    </div>
                                                </div>
                                                <div
                                                    class="c16f2viy atm_9s_1txwivl atm_h_1fhbwtr atm_fc_1y6m0gg atm_be_1g80g66 atm_gz_1xo9vth atm_h0_1xo9vth atm_vy_1pz0x4r atm_gz_1xo9vth__kgj4qw atm_h0_1xo9vth__kgj4qw atm_vy_1pz0x4r__kgj4qw atm_gz_gsbcly__oggzyc atm_h0_gsbcly__oggzyc atm_vy_1mqvw0v__oggzyc atm_gz_gsbcly__1v156lz atm_h0_gsbcly__1v156lz atm_vy_1mqvw0v__1v156lz atm_gz_gsbcly__qky54b atm_h0_gsbcly__qky54b atm_vy_1mqvw0v__qky54b atm_gz_gsbcly__jx8car atm_h0_gsbcly__jx8car atm_vy_1mqvw0v__jx8car dir dir-rtl">
                                                    @foreach($ad->attributes[$keyFe]['attributes'] as $attr)
                                                        <div
                                                            class=_fr8gbb7>
                                                            <div
                                                                class="iikjzje atm_9s_1txwivl atm_h_1h6ojuz atm_j3_e9shpx__oggzyc m10xc1ab atm_le_1tcgj5g i1fpqhzs atm_fc_esu3gu atm_ar_1sbvcyy dir dir-rtl">
                                                                <div>
                                                                    {{$attr->key}} - {{$attr->value ?? $attr->key_options}}
                                                                </div>
                                                                <div
                                                                    class="ihkmq0n atm_jb_1tcgj5g i9r7t13 atm_h0_exct8b atm_gz_idpfg4 dir dir-rtl">
                                                                    <svg xmlns=http://www.w3.org/2000/svg
                                                                        viewBox="0 0 32 32"
                                                                        aria-hidden=true
                                                                        role=presentation
                                                                        focusable=false
                                                                        style=display:block;height:24px;width:24px;fill:currentcolor>
                                                                        <path
                                                                            d="M25 1a2 2 0 0 1 2 1.85V29h2v2H3v-2h2V3a2 2 0 0 1 1.85-2H7zm0 2H7v26h18zm-9 6a3 3 0 0 1 3 2.82V14a5 5 0 1 1-6 0v-2a3 3 0 0 1 3-3zm0 6a3 3 0 1 0 0 6 3 3 0 0 0 0-6zm0 2a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm0-6a1 1 0 0 0-1 .88V13.1a5.02 5.02 0 0 1 2 0V12a1 1 0 0 0-1-1z">
                                                                        </path>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=_2us81p2>
                            <div class=_1hlms2yp>
                                <div style=padding-bottom:48px>
                                    <div data-pageslot=true
                                        class="c1yo0219 atm_9s_1txwivl_vmtskl atm_92_1yyfdc7_vmtskl atm_9s_1txwivl_9in345 atm_92_1yyfdc7_9in345 dir dir-rtl">
                                        <div style=--gp-section-max-width:1120px
                                            data-reactroot>
                                            <div
                                                style=margin-top:32px;--gp-section-top-margin:32>
                                                <div data-plugin-in-point-id=BOOK_IT_SIDEBAR
                                                    data-section-id=BOOK_IT_SIDEBAR>
                                                    <div
                                                        style="border:0px solid rgb(221,221,221);border-radius:12px;padding:24px;box-shadow:rgba(0,0,0,0.12) 0px 6px 16px">
                                                        <div>
                                                            <div
                                                                class=_1xm48ww>
                                                                <div class=_wgmchy
                                                                    data-testid=book-it-default>
                                                                    <div
                                                                        class=_1k1ce2w>
                                                                        <div
                                                                            style=--pricing-guest-display-price-alignment:flex-start;--pricing-guest-display-price-flex-wrap:wrap;--pricing-guest-primary-line-font-size:var(--linaria-theme_typography-titles-semibold_22_26-font-size);--pricing-guest-primary-line-line-height:var(--linaria-theme_typography-titles-semibold_22_26-line-height);--pricing-guest-primary-line-unit-price-font-weight:var(--linaria-theme_typography-weight-semibold600);--pricing-guest-primary-line-unit-price-color:#222222;--pricing-guest-primary-line-strikethrough-price-color:#6A6A6A;--pricing-guest-primary-line-strikethrough-font-size:var(--linaria-theme_typography-titles-semibold_22_26-font-size);--pricing-guest-primary-line-strikethrough-line-height:var(--linaria-theme_typography-titles-semibold_22_26-line-height);--pricing-guest-primary-line-trailing-content-color:#222222;--pricing-guest-primary-line-trailing-content-font-size:0.875rem;--pricing-guest-secondary-line-font-size:0.875rem;--pricing-guest-secondary-line-line-height:1.125rem;--pricing-guest-secondary-line-color:#222222;--pricing-guest-explanation-disclaimer-font-size:0.875rem;--pricing-guest-explanation-disclaimer-line-height:1.125rem;--pricing-guest-primary-line-unit-price-text-decoration:none;--pricing-guest-structured-trailing-content-font-size:0.875rem;--pricing-guest-structured-trailing-content-line-height:1.125rem;--pricing-guest-explanation-line-group-padding-top:1rem;--pricing-guest-explanation-line-item-padding-top:1rem;--pricing-guest-primary-line-strikethrough-price-font-weight:500;--pricing-guest-primary-line-qualifier-font-size:1rem;--pricing-guest-primary-line-qualifier-line-height:20px;--pricing-guest-primary-line-qualifier-color:#222222;--pricing-guest-primary-line-qualifier-font-weight:400>
                                                                            <div
                                                                                class=_w3xh25>
                                                                                <span
                                                                                    class="p52t2k0 atm_mk_h2mmj6 c1qzfr7o atm_9s_1txwivl atm_h_1q9ycp6 atm_ar_1ynjn1l atm_ar_1wwmuuc__600n0r atm_ar_1ynjn1l__qky54b dir dir-rtl">
                                                                                    <div>
                                                                                        <div class="c33effx atm_h_1q9ycp6 atm_7l_ul0h2q atm_9s_1txwivl atm_c8_10rxx23 atm_g3_y9dkmg atm_fc_dhkbu5 atm_be_u5c4bi dir dir-rtl"
                                                                                            aria-hidden=true>
                                                                                            <span>
                                                                                                <div
                                                                                                    class=_10d7v0r>
                                                                                                    <button
                                                                                                        type=button
                                                                                                        class="_194r9nk1 l1ovpqvx atm_1he2i46_1k8pnbi_10saat9 atm_yxpdqi_1pv6nv4_10saat9 atm_1a0hdzc_w1h1e8_10saat9 atm_2bu6ew_929bqk_10saat9 atm_12oyo1u_73u7pn_10saat9 atm_fiaz40_1etamxe_10saat9 dir dir-rtl"
                                                                                                        style=text-align:start><span
                                                                                                            class="umg93v9 atm_7l_rb934l atm_cs_1peztlj atm_rd_14k51in atm_cs_kyjlp1__1v156lz dir dir-rtl"
                                                                                                            style=--pricing-guest-primary-line-unit-price-text-decoration:none> {{Currency::CURRENCY[$ad->currency_id]}} {{ $ad->price}}</span></button>
                                                                                                </div>
                                                                                            </span>&nbsp;
                                                                                        </div>
                                                                                    </div>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        class=_p03egf>
                                                                        <div
                                                                            class="can6x7v atm_mk_h2mmj6 dir dir-rtl">
                                                                            <div>
                                                                                <div class="c3q2aui atm_2d_1qwqy05 atm_mk_h2mmj6 dir dir-rtl"
                                                                                    style=border-radius:8px>
                                                                                    <div
                                                                                        class="r1el1iwj atm_9s_1txwivl dir dir-rtl">
                                                                                        <div
                                                                                            class=_zdxht7>
                                                                                            <div class="cc9lcoh atm_mk_h2mmj6 d1nva1nl atm_am_1xdxr68 atm_wq_1pzmwj7 dir dir-rtl"
                                                                                                style=--dls-comboelement-flex:1>
                                                                                                <div role=presentation
                                                                                                    class="btvh8ou atm_mk_stnw88 atm_mj_glywfm d1j9pcto atm_tk_1b3d9n1 atm_fq_fvak1h atm_n3_sp2ea atm_6i_vp17w8 atm_6a_i9lela atm_6c_pl7ray atm_45_1sj0iy5 atm_43_1sbhxya atm_26_j8unkq dir dir-rtl"
                                                                                                    style=--dls-comboelement-background-top:0px;--dls-comboelement-background-left:0px;--dls-comboelement-background-right:0px;--dls-comboelement-background-bottom:-1px;--dls-comboelement-background-border-top-left-radius:8px;--dls-comboelement-background-border-top-right-radius:8px;--dls-comboelement-background-border-bottom-right-radius:0px;--dls-comboelement-background-border-bottom-left-radius:0px;--dls-comboelement-background-background:var(--comboInputGroup_backgroundColor,none)>
                                                                                                </div>
                                                                                                <button
                                                                                                    class=_17qbp1i
                                                                                                    aria-label="تغيير التواريخ; تسجيل الوصول: 2025-08-28; تسجيل المغادرة: 2025-08-30"
                                                                                                    type=button>
                                                                                                    <div
                                                                                                        class=_19y8o0j>
                                                                                                        <div class=_fx8ceg>
                                                                                                            تاريخ الاعلان
                                                                                                        </div>
                                                                                                        <div class=_v77t70
                                                                                                            data-testid=change-dates-checkIn>{{ $ad->created_at->format('Y-m-d') }}</div>
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class=_38rbfft>
                                                                                                        <div class=_fx8ceg>
                                                                                                            عدد المشاهدات
                                                                                                        </div>
                                                                                                        <div class=_v77t70 data-testid=change-dates-checkOut>
                                                                                                            {{ $ad->show_count }}
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </button>
                                                                                                <div class="fjvzknw atm_mk_stnw88 atm_mj_glywfm atm_66_nqa18y dj95cgj atm_tk_ijdry atm_fq_h0a6y9 atm_n3_7fjwbr atm_6i_1q8v4pf atm_6a_d3kcmh atm_6c_1m6y5xd atm_45_1tgadlc atm_43_qujuqm atm_68_id5i0b atm_5r_zbl5mk atm_41_10ne3g8 atm_5f_ckphc3 atm_6h_k1jhqi atm_wq_gq23zm dir dir-rtl"
                                                                                                    style=--dls-comboelement-foreground-top:0px;--dls-comboelement-foreground-left:0px;--dls-comboelement-foreground-right:0px;--dls-comboelement-foreground-bottom:-1px;--dls-comboelement-foreground-border-top-left-radius:8px;--dls-comboelement-foreground-border-top-right-radius:8px;--dls-comboelement-foreground-border-bottom-right-radius:0px;--dls-comboelement-foreground-border-bottom-left-radius:0px;--dls-comboelement-foreground-border-top-color:var(--comboInputGroup_borderColor,var(--linaria-theme_palette-border-quarternary));--dls-comboelement-foreground-border-right-color:var(--comboInputGroup_borderColor,var(--linaria-theme_palette-border-quarternary));--dls-comboelement-foreground-border-bottom-color:var(--comboInputGroup_borderColor,var(--linaria-theme_palette-border-quarternary));--dls-comboelement-foreground-border-left-color:var(--comboInputGroup_borderColor,var(--linaria-theme_palette-border-quarternary));--dls-comboelement-foreground-border-width:1px;--dls-comboelement-foreground-z-index:0>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div
                                                                                        class="r1el1iwj atm_9s_1txwivl dir dir-rtl">
                                                                                        <div
                                                                                            class=_bp34sw>
                                                                                            <div class="cc9lcoh atm_mk_h2mmj6 d1nva1nl atm_am_1xdxr68 atm_wq_1pzmwj7 dir dir-rtl"
                                                                                                style=--dls-comboelement-flex:1>
                                                                                                <div role=presentation
                                                                                                    class="btvh8ou atm_mk_stnw88 atm_mj_glywfm d1j9pcto atm_tk_1b3d9n1 atm_fq_fvak1h atm_n3_sp2ea atm_6i_vp17w8 atm_6a_i9lela atm_6c_pl7ray atm_45_1sj0iy5 atm_43_1sbhxya atm_26_j8unkq dir dir-rtl"
                                                                                                    style=--dls-comboelement-background-top:0px;--dls-comboelement-background-left:0px;--dls-comboelement-background-right:0px;--dls-comboelement-background-bottom:-1px;--dls-comboelement-background-border-top-left-radius:0px;--dls-comboelement-background-border-top-right-radius:0px;--dls-comboelement-background-border-bottom-right-radius:8px;--dls-comboelement-background-border-bottom-left-radius:8px;--dls-comboelement-background-background:var(--comboInputGroup_backgroundColor,none)>
                                                                                                </div>
                                                                                                <div class=_1wvvj01
                                                                                                    aria-expanded=false
                                                                                                    aria-haspopup=true
                                                                                                    aria-labelledby="guests-label GuestPicker-book_it-trigger"
                                                                                                    aria-disabled=false
                                                                                                    role=button
                                                                                                    tabindex=0>
                                                                                                    <label for=GuestPicker-book_it-trigger class=_13kgb0p>
                                                                                                        <div class=_fx8ceg>
                                                                                                            المدينة
                                                                                                        </div>
                                                                                                        <div class=_1xxn77q
                                                                                                            id=GuestPicker-book_it-trigger
                                                                                                            aria-invalid=false
                                                                                                            aria-disabled=false>
                                                                                                            <div class=_1e5z145>
                                                                                                                <span class=_j1kt73>
                                                                                                                    <p>المدينة: {{ $ad->city ? $ad->city->name : 'Unknown' }}</p>
                                                                                                                    {{-- <p>Area: {{ $ad->area ? $ad->area->name : 'Unknown' }}</p> --}}
                                                                                                                </span>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </label>
                                                                                                </div>
                                                                                                <div class="fjvzknw atm_mk_stnw88 atm_mj_glywfm atm_66_nqa18y dj95cgj atm_tk_ijdry atm_fq_h0a6y9 atm_n3_7fjwbr atm_6i_1q8v4pf atm_6a_d3kcmh atm_6c_1m6y5xd atm_45_1tgadlc atm_43_qujuqm atm_68_id5i0b atm_5r_zbl5mk atm_41_10ne3g8 atm_5f_ckphc3 atm_6h_k1jhqi atm_wq_gq23zm dir dir-rtl"
                                                                                                    style=--dls-comboelement-foreground-top:0px;--dls-comboelement-foreground-left:0px;--dls-comboelement-foreground-right:0px;--dls-comboelement-foreground-bottom:-1px;--dls-comboelement-foreground-border-top-left-radius:0px;--dls-comboelement-foreground-border-top-right-radius:0px;--dls-comboelement-foreground-border-bottom-right-radius:8px;--dls-comboelement-foreground-border-bottom-left-radius:8px;--dls-comboelement-foreground-border-top-color:var(--comboInputGroup_borderColor,var(--linaria-theme_palette-border-quarternary));--dls-comboelement-foreground-border-right-color:var(--comboInputGroup_borderColor,var(--linaria-theme_palette-border-quarternary));--dls-comboelement-foreground-border-bottom-color:var(--comboInputGroup_borderColor,var(--linaria-theme_palette-border-quarternary));--dls-comboelement-foreground-border-left-color:var(--comboInputGroup_borderColor,var(--linaria-theme_palette-border-quarternary));--dls-comboelement-foreground-border-width:1px;--dls-comboelement-foreground-z-index:0>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div data-pageslot=true
                                        class="c1yo0219 atm_9s_1txwivl_vmtskl atm_92_1yyfdc7_vmtskl atm_9s_1txwivl_9in345 atm_92_1yyfdc7_9in345 dir dir-rtl">
                                        <div
                                            style=--gp-section-max-width:1120px>
                                            <div
                                                style=margin-top:24px;--gp-section-top-margin:24>
                                                <div data-plugin-in-point-id=REPORT_TO_AIRBNB
                                                    data-section-id=REPORT_TO_AIRBNB>
                                                    <div
                                                        class="cbiapkd atm_h3_1tcgj5g__600n0r atm_r3_1h6ojuz__600n0r dir dir-rtl">
                                                        <button
                                                            data-testid=user-flag-report-button
                                                            type=button
                                                            class="l1ovpqvx atm_1he2i46_1k8pnbi_10saat9 atm_yxpdqi_1pv6nv4_10saat9 atm_1a0hdzc_w1h1e8_10saat9 atm_2bu6ew_929bqk_10saat9 atm_12oyo1u_73u7pn_10saat9 atm_fiaz40_1etamxe_10saat9 b1lnvd7y atm_c8_1kw7nm4 atm_bx_1kw7nm4 atm_cd_1kw7nm4 atm_ci_1kw7nm4 atm_g3_1kw7nm4 atm_9j_tlke0l_1nos8r_uv4tnr atm_7l_1kw7nm4_pfnrn2 atm_rd_8stvzk_pfnrn2 c8bhioi atm_1s_glywfm atm_26_1j28jx2 atm_3f_idpfg4 atm_9j_tlke0l atm_gi_idpfg4 atm_l8_idpfg4 atm_vb_1wugsn5 atm_7l_jt7fhx atm_rd_8stvzk atm_5j_1896hn4 atm_cs_10d11i2 atm_r3_1kw7nm4 atm_mk_h2mmj6 atm_kd_glywfm atm_9j_13gfvf7_1o5j5ji atm_7l_jt7fhx_v5whe7 atm_rd_8stvzk_v5whe7 atm_7l_177r58q_1nos8r_uv4tnr atm_rd_8stvzk_1nos8r_uv4tnr atm_7l_9vytuy_4fughm_uv4tnr atm_rd_8stvzk_4fughm_uv4tnr atm_rd_8stvzk_xggcrc_uv4tnr atm_7l_1he744i_csw3t1 atm_rd_8stvzk_csw3t1 atm_3f_glywfm_jo46a5 atm_l8_idpfg4_jo46a5 atm_gi_idpfg4_jo46a5 atm_3f_glywfm_1icshfk atm_kd_glywfm_19774hq atm_7l_jt7fhx_1w3cfyq atm_rd_8stvzk_1w3cfyq atm_uc_aaiy6o_1w3cfyq atm_70_1p56tq7_1w3cfyq atm_uc_glywfm_1w3cfyq_1rrf6b5 atm_7l_9vytuy_1o5j5ji atm_rd_8stvzk_1o5j5ji atm_rd_8stvzk_1mj13j2 dir dir-rtl"><span
                                                                class="b3g8a7f atm_h_1h6ojuz atm_9s_1txwivl atm_bx_48h72j atm_cs_10d11i2 blaqe8x atm_c8_km0zk7 atm_g3_18khvle atm_fr_1m9t47k bm80kjo atm_7l_1esdqks dir dir-rtl"><span
                                                                    class="iziq4yk atm_h0_exct8b dir dir-rtl"><svg
                                                                        viewBox="0 0 16 16"
                                                                        xmlns=http://www.w3.org/2000/svg
                                                                        aria-hidden=true
                                                                        role=presentation
                                                                        focusable=false
                                                                        style=display:block;height:16px;width:16px;fill:currentcolor>
                                                                        <path
                                                                            d="m7.5011 1c.5272 0 .9591.40794.99725.92537l.00275.07463v1h5.5c.31265 0 .5435.281645.4935.581075l-.01275.056285-.96125 3.36264.96125 3.36265c.08055.2818-.0967.5625-.36775.62465l-.0554.00945-.0576.00325h-5.5c-.5272 0-.9591-.40795-.99725-.92535l-.00275-.07465v-1h-5v6h-1v-14zm1 3h-1v4h1z">
                                                                        </path>
                                                                    </svg></span>الإبلاغ
                                                                عن
                                                                هذا
                                                                الإعلان
                                                            </span></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div data-pageslot=true
                    class="c1yo0219 atm_9s_1txwivl_vmtskl atm_92_1yyfdc7_vmtskl atm_9s_1txwivl_9in345 atm_92_1yyfdc7_9in345 dir dir-rtl">
                    <div style=--gp-section-max-width:1120px>
                        <div class=_v2335w>
                            <div class="plmw1e5 atm_e2_1osqo2v atm_gz_1wugsn5 atm_h0_1wugsn5 atm_vy_1osqo2v mq5rv0q atm_j3_1v7vjkn dir dir-rtl"
                                style=--maxWidth:1120px>
                                <div class=_npr0qi
                                    style=border-top-color:rgb(221,221,221)>
                                </div>
                                <div data-plugin-in-point-id=REVIEWS_DEFAULT
                                    data-section-id=REVIEWS_DEFAULT
                                    style=padding-top:48px;padding-bottom:48px>
                                    <div>
                                        <section>
                                            <div
                                                class="giqmusi atm_9s_1txwivl atm_ar_1bp4okc atm_h_1h6ojuz atm_gq_1vi7ecw atm_r3_1h6ojuz atm_h3_exct8b__oggzyc atm_gq_1fwpi09__oggzyc dir dir-rtl">
                                                <div
                                                    class="c139f2ip atm_9s_1txwivl atm_cs_10d11i2 atm_fc_1h6ojuz atm_r3_1h6ojuz c1ulwnyr atm_cx_i2wt44 tpr33qy atm_h_1y6m0gg dir dir-rtl">
                                                    <div
                                                        style=width:auto;height:132px>
                                                        <div class="d5pn26n atm_9s_1o8liyq atm_vh_yfq0k3 atm_e2_88yjaz atm_vy_1r2rij0 atm_j6_t94yts b1see6r9 atm_2m_1qred53 atm_2s_mgnkw2 dir dir-rtl"
                                                            role=presentation
                                                            aria-hidden=true
                                                            style=--dls-liteimage-height:132px;--dls-liteimage-width:86.70588235294117px;--dls-liteimage-background-image:url(data:image/png;base64,null);--dls-liteimage-background-size:contain>
                                                            <img class="i17a04ne atm_e2_1osqo2v atm_vy_1osqo2v atm_mk_pfqszd ijnw5wu atm_jp_pyzg9w atm_jr_nyqth1 i1s295uf atm_vh_yfq0k3 dir dir-rtl"
                                                                aria-hidden=true
                                                                decoding=async
                                                                elementtiming=LCP-target
                                                                src="data:image/avif;base64,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"
                                                                data-original-uri=https://a0.muscache.com/im/pictures/airbnb-platform-assets/AirbnbPlatformAssets-GuestFavorite/original/b4005b30-79ff-4287-860c-67829ecd7412.png
                                                                style=--dls-liteimage-object-fit:contain>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="gvcwa6y atm_h3_12gsa0d atm_fr_12gsa0d atm_7l_dezgoh atm_c8_t9kd1m atm_g3_t9kd1m atm_h3_1n1ank9__uwn79d atm_c8_12am3vd__uwn79d atm_g3_12am3vd__uwn79d atm_h3_1bs0ed2__oggzyc atm_c8_12xxubj__oggzyc atm_g3_12xxubj__oggzyc dir dir-rtl">
                                                        <h2 tabindex=-1
                                                            class="hpipapi atm_7l_1kw7nm4 atm_c8_1x4eueo atm_cs_1kw7nm4 atm_g3_1kw7nm4 atm_gi_idpfg4 atm_l8_idpfg4 atm_kd_idpfg4_pfnrn2 dir dir-rtl"
                                                            elementtiming=LCP-target>
                                                            <span
                                                                class="a8jt5op atm_3f_idpfg4 atm_7h_hxbz6r atm_7i_ysn8ba atm_e2_t94yts atm_ks_zryt35 atm_l8_idpfg4 atm_mk_stnw88 atm_vv_1q9ccgz atm_vy_t94yts dir dir-rtl">تم
                                                                تقييمها
                                                                4.9
                                                                من 5
                                                                من
                                                                قبل
                                                                31
                                                                تقييمًا.</span>
                                                            <div
                                                                aria-hidden=true>
                                                                4.9
                                                            </div>
                                                        </h2>
                                                    </div>
                                                    <div
                                                        style=width:auto;height:132px>
                                                        <div class="d5pn26n atm_9s_1o8liyq atm_vh_yfq0k3 atm_e2_88yjaz atm_vy_1r2rij0 atm_j6_t94yts b1see6r9 atm_2m_1qred53 atm_2s_mgnkw2 dir dir-rtl"
                                                            role=presentation
                                                            aria-hidden=true
                                                            style=--dls-liteimage-height:132px;--dls-liteimage-width:86.70588235294117px;--dls-liteimage-background-image:url(data:image/png;base64,null);--dls-liteimage-background-size:contain>
                                                            <img class="i17a04ne atm_e2_1osqo2v atm_vy_1osqo2v atm_mk_pfqszd ijnw5wu atm_jp_pyzg9w atm_jr_nyqth1 i1s295uf atm_vh_yfq0k3 dir dir-rtl"
                                                                aria-hidden=true
                                                                decoding=async
                                                                elementtiming=LCP-target
                                                                src="data:image/avif;base64,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"
                                                                data-original-uri=https://a0.muscache.com/im/pictures/airbnb-platform-assets/AirbnbPlatformAssets-GuestFavorite/original/78b7687c-5acf-4ef8-a5ea-eda732ae3b2f.png
                                                                style=--dls-liteimage-object-fit:contain>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div
                                                    class="gzon5f2 atm_c8_imiupd atm_g3_1slol46 atm_cs_10d11i2 atm_by_4iukzz atm_le_ftgil2 dir dir-rtl">
                                                    مفضّل لدى الضيوف
                                                </div>
                                                <div
                                                    class="g1svj0ba atm_c8_1cw7z3g atm_g3_92qb7l atm_fr_1bq7tds atm_7l_1esdqks atm_j3_1lvxp6z atm_c8_vvn7el__qky54b atm_g3_k2d186__qky54b atm_fr_1vi102y__qky54b atm_j3_x4xq5r__qky54b dir dir-rtl">
                                                    <span
                                                        class="l1h825yc atm_kd_19r6f69_24z95b dir dir-rtl">هذا
                                                        المسكن هو
                                                        مفضّل لدى
                                                        الضيوف،
                                                        استنادًا إلى
                                                        التقييمات
                                                        والمراجعات
                                                        وبيانات
                                                        الموثوقية</span>
                                                </div>
                                            </div>
                                            
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div data-pageslot=true
                    class="c1yo0219 atm_9s_1txwivl_vmtskl atm_92_1yyfdc7_vmtskl atm_9s_1txwivl_9in345 atm_92_1yyfdc7_9in345 dir dir-rtl">
                    <div style=--gp-section-max-width:1120px>
                        <div class=_v2335w>
                            <div class="plmw1e5 atm_e2_1osqo2v atm_gz_1wugsn5 atm_h0_1wugsn5 atm_vy_1osqo2v mq5rv0q atm_j3_1v7vjkn dir dir-rtl"
                                style=--maxWidth:1120px>
                                <div class=_npr0qi
                                    style=border-top-color:rgb(221,221,221)>
                                </div>
                                <div data-plugin-in-point-id=LOCATION_DEFAULT
                                    data-section-id=LOCATION_DEFAULT
                                    style=padding-top:48px;padding-bottom:48px>
                                    <section>
                                            <div id="map"></div>

                                            
                                            {{-- <a class="map-btn"
                                            href="https://www.google.com/maps?q={{ $ad->lat }},{{ $ad->lng }}"
                                            target="_blank">
                                            📍 افتح الموقع في خرائط Google
                                            </a> --}}
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="cxnsl1q atm_j3_1osqo2v atm_mk_1n9t6rb atm_wq_115503r atm_vy_1osqo2v atm_6i_u29brm atm_fq_idpfg4 atm_r3_1h6ojuz atm_l8_197tx09 atm_vy_ixjv83__oggzyc atm_fq_1vi7ecw__oggzyc atm_6i_1wqb8tt__oggzyc atm_r3_1kw7nm4__oggzyc atm_l8_idpfg4__oggzyc dir dir-rtl">
            </div>
        </div>
            {{-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBmUBKuEtOb82IFN-XpmZTz7C4aBRKprKM&libraries=places&callback=initMap"></script> --}}
            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBmUBKuEtOb82IFN-XpmZTz7C4aBRKprKM&libraries=places&callback=initMap"></script>

                <!-- Google Maps API -->
            <script>
                function initMap() {
                    var location = { lat: {{ $ad->lat }}, lng: {{ $ad->lng }} };

                    var map = new google.maps.Map(document.getElementById('map'), {
                        zoom: 14,
                        center: location,
                        mapTypeId: 'roadmap'
                    });

                    var marker = new google.maps.Marker({
                        position: location,
                        map: map,
                        title: "{{ $ad->title }}"
                    });

                    var infoWindow = new google.maps.InfoWindow({
                        content: "<strong>{{ $ad->title }}</strong>"
                    });

                    marker.addListener("click", function() {
                        infoWindow.open(map, marker);
                    });
                }

                // استدعاء الدالة بعد تحميل الصفحة
                window.onload = initMap;
            </script>
            <script>
                let slideIndex = 1;

                function openGallery(n) {
                    document.getElementById('galleryModal').style.display = 'flex';
                    showSlide(n);
                }

                function closeGallery() {
                    document.getElementById('galleryModal').style.display = 'none';
                }

                function plusSlides(n) {
                    showSlide(slideIndex += n);
                }

                function showSlide(n) {
                    let slides = document.getElementsByClassName("gallerySlide");
                    if (n > slides.length) slideIndex = 1;
                    if (n < 1) slideIndex = slides.length;
                    for (let i = 0; i < slides.length; i++) {
                        slides[i].style.display = "none";
                    }
                    slides[slideIndex-1].style.display = "block";
                }
            </script>
                                                      
@endsection