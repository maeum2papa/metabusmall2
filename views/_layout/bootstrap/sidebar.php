<!-- sidebar start -->
<?php
// $this->load->view(element('layout_skin_path', $layout) . '/box/login');
// $this->load->view(element('layout_skin_path', $layout) . '/box/latest');
// $this->load->view(element('layout_skin_path', $layout) . '/box/tagcloud');
$rank = seum_rank($this->member->item('company_idx'),$this->member->item('mem_id'));
?>

<!-- asmo sh 231120 사이드바 생성 -->
<div id="asmo_sidebar">
    <div class="sidebar_wrap">
        <section class="sidebar_top">
            <div class="sidebar_menu">
                <ul>

                    <li id="asmo_sidebar_logo">
                        <a href="<?php echo site_url('dashboard'); ?>" class="sidebar_logo">
                            <span class="asmo_sidebar_icon"><img src="<?=busiIcon($this->member->item('company_idx'))?>" alt="기업 로고" onerror="this.onerror=null; this.src='<?php echo element('layout_skin_url', $layout); ?>/seum_img/sidebar/collaborlandLogo.svg'"></span>
                        
                        </a>
                    </li>

                    <li id="dashboard">
                        <a href="<?php echo site_url('dashboard'); ?>" class="sidebar_logo">
                            <span class="asmo_sidebar_icon"></span>
                        
                            <div class="asmo_menu_hover">
                                <p>대시보드</p>
                            </div>  
                        </a>
                    </li>
                    
                    <li id="myland">
                        <a href="<?php echo site_url('myland/space'); ?>">
                            <span class="asmo_sidebar_icon"></span>

                            <div class="asmo_menu_hover">
                                <p>마이랜드</p>
                            </div>  
                        </a>
                    </li>
                    <li id="officeland">
                        <a href="<?php echo site_url('land/office'); ?>">
                            <span class="asmo_sidebar_icon"></span>

                            <div class="asmo_menu_hover">
                                <p><?=busiNm($this->member->item('company_idx'))?>랜드</p>
                            </div>  
                        </a>
                    </li>
                    <li id="classroom">
                        <a href="<?php echo site_url('classroom'); ?>">
                            <span class="asmo_sidebar_icon"></span>
                            <div class="asmo_menu_hover">
                                <p>클래스룸</p>
                            </div>  
                        </a>
                    </li>
                    <li id="shop">
                        <a href="<?php echo site_url('cmall'); ?>">
                            <span class="asmo_sidebar_icon"></span>

                            <div class="asmo_menu_hover">
                                <p>교환소</p>
                            </div>  
                        </a>
                    </li>
                </ul>
            </div>
        </section>

        <section class="sidebar_bottom">
            <div class="sidebar_menu">
                <ul>
                    <li id="asmo_info">
                        <a href="<?php echo site_url('faq/faq'); ?>" class="sidebar_logo">
                            <span class="asmo_sidebar_icon"></span>
                        
                            <div class="asmo_menu_hover">
                                <p>컬래버랜드 이용에 <br> 도움이 필요하신가요?</p>
                            </div>  
                        </a>
                    </li>

                        <?php if (($this->member->is_admin() === 'super' || $this->session->userdata['mem_admin_flag'] == 1) || ($this->member->item('mem_is_admin') == '0' && $this->member->item('mem_level') == '100')) { ?>                        
                    <li id="asmo_admin">
                        <a href="<?php echo site_url('admin'); ?>">
                            <span class="asmo_sidebar_icon"></span>

                            <div class="asmo_menu_hover">
                                <p>기업관리</p>
                            </div>  
                        </a>
                    </li>
                    <?php } ?>  
                    <li id="asmo_logout">
                        <a href="<?php echo site_url('login/logout?url=' . urlencode(current_full_url())); ?>">
                            <span class="asmo_sidebar_icon"></span>

                            <div class="asmo_menu_hover">
                                <p>로그아웃</p>
                            </div>  
                        </a>
                    </li>
                    
                </ul>
            </div>
        </section>
    </div>

    
    
</div>



<!-- sidebar end -->
