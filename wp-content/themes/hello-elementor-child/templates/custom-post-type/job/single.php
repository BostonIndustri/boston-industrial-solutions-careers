<?php get_header(); ?>
<?php
$job_title = get_the_title( get_the_ID() );
$job_location = get_field( 'job_location', get_the_ID() );
?>
<section class="job-detail-main">
    <div class="container-boston">
        <h1><?php echo esc_html( $job_title ); ?></h1>
        <div class="boosten-bradcom">
            <ul>
                <li>
                    CARRERS
                </li>
                <li>
                    <a href="javascript:void(0);">
                    <?php echo esc_html( $job_title ); ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</section>

<section class="job-secondblock">
    <div class="container-boston">
        <div class="jobdetailsbox">
             <div class="jobdetailsbox-left">
                <h2><?php echo esc_html( $job_title ); ?><span><?php echo esc_html( $job_location ); ?></span></h2>
                <p>
                    Pad printing inks for any application from Boston Industrial Solutions, Inc. are made with safety and sustainability in mind. Our top-quality inks are available in single- and two-component types. We make silicone, UV-curable, and solvent-based printing inks following strict quality management standards. These inks are not only enhanced and fine-tuned to adhere to the toughest substrates (materials) in the world, but they are also made to exceed ATSM, medical, and mil-spec standards. Many industries and Fortune 500 companies use these inks for printing, marking, and decorating parts. Boston Industrial Solutions, Inc. inks work effectively with any pad printing equipment, regardless of the manufacturer. Additionally, these inks achieve excellent results every time. Furthermore, we are constantly innovating to meet and exceed ever-changing compliance, consumer, and industrial applications.
                </p> 
                <div class="jobdetailsboxwithlist">
                    <h3>Duties and Responsibilities:</h3>    
                    <ul>
                        <li>
                             Perform installations and repairs of digital inkjet equipment at customer sites
                        </li>
                        <li>
                             Provide training to customers on proper operation and maintenance of equipment, digital file preparation, and RIP processing 
                        </li>
                        <li>
                             Remote customer support and troubleshooting, as well as on-site service as needed
                        </li>
                        <li>
                             Effectively communicate and obtain appropriate data needed to identify, analyze, and resolve service requirements
                        </li>
                        <li>
                             Clearly communicate problem solutions through database entries, written reports and verbal communication with customers and colleagues
                        </li>
                        <li>
                             Maintaining of demonstration and test facilities
                        </li>
                        <li>
                             Imaging of printed samples for customers and marketing
                        </li>
                    </ul>
                </div>

                <div class="jobdetailsboxwithlist">
                    <h3>Qualifications:</h3>    
                    <ul>
                        <li>
                             Associate Degree or equivalent vocational training in a related field
                        </li>
                        <li>
                             Basic Graphic Arts skills with working knowledge of Adobe Creative Suite 
                        </li>
                        <li>
                             Experience in servicing and operating inkjet printing or similar equipment in a print production environment
                        </li>
                        <li>
                             Ability to work independently as well as part of a team
                        </li>
                        <li>
                             Should possess strong collaborative abilities, to not only obtain assistance form colleagues but also provide support when needed
                        </li>
                        <li>
                             Must have good colour vision and attention to detail
                        </li>
                        <li>
                             Strong aptitude for customer relations and communication skills
                        </li>
                    </ul>
                </div>
            </div>
            <div class="jobdetailsbox-right">
                <div class="jobpositnstocky">
                    <a class="applyjobbtn" href="javascript:void(0);">
                        APPLY FOR THIS POSITION
                    </a>    
                    <div class="weofferbox">
                        <h4>We offer:</h4>
                            <ul>    
                                <li>
                                    Dynamic global organization with a history of innovation and strong product portfolio
                                </li>
                                <li>
                                    Challenging environment combined with a supportive management structure
                                </li>
                                <li>
                                    Career development and growth
                                </li>
                                <li>
                                    Competitive salary and benefit package
                                </li>
                                <li>
                                    Friendly work environment surrounded by dedicated and professional colleagues
                                </li>
                                <li>
                                    Full training on all aspects of our inkjet machines with a training plan
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</section>

<section class="jobdetailapplyforposition">
    <div class="container-boston">
        <h5>APPLY FOR THIS POSITION</h5>  
        <form class="jobdetailform" action="" method="">
            <div>
            <div class="jobformcontrols">
                <div class="namegroup">
                    <label>FIRST NAME *</label>
                    <input type="text" id="firstname" name="fname" />
                </div>

                <div class="namegroup">
                    <label>LAST NAME *</label>
                    <input type="text" id="lastname" name="lname" />
                </div>
            </div>

            <div class="jobformcontrols">
                <div class="namegroup">
                    <label>EMAIL ADDRESS *</label>
                    <input type="email" id="email" name="email" />
                </div>

                <div class="namegroup">
                    <label>HOW DID YOU HEAR ABOUT US? *</label>
                    <select>
                        <option value="">google</option>
                        <option value="">website</option>
                        <option value="">whatsapp</option>
                        <option value="">instagram</option>
                    </select>
                </div>
            </div>

            <div class="jobformcontrols">
                <div class="namegroup">
                    <label>COMMENTS</label>
                    <textarea id="comments" name="comments">
                        
                    </textarea>
                </div>

                <div class="namegroup">
                    <ul>
                        <li>
                            <label>UPLOAD COVER LETTER</label>
                            <p>Max. file size: 29 MB</p>
                        </li>
                        <li>
                            <div class="upload-btn-wrapper">
                                <button class="btn">CHOOSE FILE</button>
                                <input type="file" id="coverletter" name="coverletter">
                            </div>    
                        </li>
                    </ul>

                    <ul>
                        <li>
                            <label>UPLOAD RESUME</label>
                            <p>Max. file size: 29 MB</p>
                        </li>
                        <li>
                            <div class="upload-btn-wrapper">
                                <button class="btn">CHOOSE FILE</button>
                                <input type="file" id="coverletter" name="coverletter">
                            </div>    
                        </li>
                    </ul>

                    <input type="submit" value="SUBMIT">
                </div>
            </div>
            </div>
            <div class="termsbox">
                <input type="checkbox" id="html">
                <label for="html">By checking this box you agree to <a href="javascript:void(0);">Boston Industrial Solutions</a> Privacy Policy.</label>
            </div>
        </form>
    </div>
</section>

<?php get_footer();