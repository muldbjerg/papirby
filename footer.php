    </main> <!-- END SIDE-CONTENT -->
    
    </div> <!-- END SITE-WRAPPER -->   
    
    
    <footer class="main-footer">
        <div class="footer-content">
            <div class="site-wrapper">      
                <div>
                    <svg width="48" height="43" viewBox="0 0 48 43" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.1324 0.491644C15.6597 6.19181 19.4006 11.8226 22.0073 22.2383H20.7103C19.8648 14.2411 11.2387 3.90854 1.98047 5.72367C3.56264 1.47952 8.90678 0.216182 14.1324 0.491644Z" fill="#fff"/>
                        <path d="M11.445 15.5508C9.18754 14.3621 5.02066 12.4088 2.99681 12.8198C2.99681 12.8198 1.32847 14.2061 0 14.1837C0 14.1837 1.24272 13.1885 1.24272 11.6964C3.27169 9.78532 6.81813 10.5141 11.445 15.5508Z" fill="#fff"/>
                        <path d="M14.4341 24.6399C14.4341 23.6573 14.9068 22.7869 15.6348 22.2371C14.1446 19.5591 9.81827 18.4751 6.70508 21.0137C9.8317 24.2149 12.0726 28.4051 13.305 32.4414C14.5266 31.9188 16.6352 29.948 16.6517 27.5435C15.3743 27.194 14.4341 26.0283 14.4341 24.6399Z" fill="#fff"/>
                        <path d="M23.9082 40.3236C24.6611 40.3236 27.1632 36.85 27.1632 35.5627C27.1632 34.2994 25.8516 32.9634 25.7301 27.5466H26.7988C26.7988 31.7974 28.2321 36.6313 30.4667 38.9633C28.572 41.3439 25.9 42.5586 23.9082 42.5586C21.9163 42.5586 19.2443 41.3439 17.3496 38.9633C19.5843 36.6313 21.0177 31.7974 21.0177 27.5466H22.0864C21.965 32.9634 20.6533 34.2994 20.6533 35.5627C20.6533 36.85 23.1552 40.3236 23.9082 40.3236Z" fill="#fff"/>
                        <path d="M33.6836 0.491644C32.1561 6.19181 28.4151 11.8226 25.8086 22.2383H27.1054C27.9513 14.2411 36.5769 3.90854 45.8354 5.72367C44.2532 1.47952 38.9089 0.216182 33.6836 0.491644Z" fill="#fff"/>
                        <path d="M36.3711 15.5508C38.6284 14.3621 42.7953 12.4088 44.8195 12.8198C44.8195 12.8198 46.4874 14.2061 47.816 14.1837C47.816 14.1837 46.5734 13.1885 46.5734 11.6964C44.5443 9.78532 40.998 10.5141 36.3711 15.5508Z" fill="#fff"/>
                        <path d="M33.3834 24.6399C33.3834 23.6573 32.9109 22.7869 32.1827 22.2371C33.6729 19.5591 37.9992 18.4751 41.1127 21.0137C37.9858 24.2149 35.7451 28.4051 34.5124 32.4414C33.291 31.9188 31.1826 29.948 31.166 27.5435C32.4433 27.194 33.3834 26.0283 33.3834 24.6399Z" fill="#fff"/>
                        <path d="M23.9171 0.000304992C22.0514 4.74088 22.9285 13.4015 23.7451 22.2422H24.0902C24.9065 13.4015 25.7834 4.74088 23.9171 0.000304992Z" fill="#fff"/>
                    </svg>
                    <p class="footer_title">Silkeborg Spejderne</p>
                    <p class="footer_subtitle">Oplevelser, udfordringer og venner i naturen</p>
                </div>

                <div class="footer-nav">
                    <div>
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'footer-1-menu',
                            'container' => 'nav',
                            'container_class' => 'footer-1-menu',
                            'menu_class' => 'footer-menu',
                        ));
                        ?>
                    </div>
                    <div>
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'footer-2-menu',
                            'container' => 'nav',
                            'container_class' => 'footer-2-menu',
                            'menu_class' => 'footer-menu',
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </footer>
<!-- 
<style>
    footer{
        padding: 20vw 0 4vw;
        font-size: 1rem;
        color: #A4927C;
    }

    footer p{
        margin: 4px 0;
    }

    footer p:first-of-type{
        font-weight: 600;
    }

    footer a, footer a:visited{
        display: inline-block;
        margin-right: 16px;
        color: #A4927C;
        transition: color 0.1s ease;
    }

    @media(hover: hover){
         footer a:hover{
            color: var(--main-text-color);
         }
    }

    
    @media only screen and (max-width: 960px) {
        footer{
            text-align: center;
        }
    }
</style> -->