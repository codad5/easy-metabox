
<div class="w-full px-4 lg:px-20 py-1o lg:py-12">
    <form method="post" class="w-full px-1 lg:px-14 lg:py-12 flex flex-col gap-5 lg:gap-7 ">
        <div class="w-full flex gap-5 lg:gap-7 flex-col lg:flex-row" >
            <div class="w-full lg:w-1/3 flex flex-col gap-3.5">
                <label class="w-full font-semibold text-base" for="cean_contact_first_name">
                    First Name
                </label>
                <div class="w-full bg-[#1A1A1A] h-12 py-4 px-5">
                    <input type="text"  name="_cean_contact_first_name" id="cean_contact_first_name" class="w-full h-full bg-transparent text-base font-normal text-[#999999] outline-none focus:outline-none placeholder-[#666666]" placeholder="Enter first name" />
                </div>
            </div>
            <div class="w-full lg:w-1/3 flex flex-col gap-3.5">
                <label class="w-full font-semibold text-base" for="cean_contact_last_name">
                    Last Name
                </label>
                <div class="w-full bg-[#1A1A1A] h-12 py-4 px-5">
                    <input type="text" name="_cean_contact_last_name" id="cean_contact_last_name" class="w-full h-full bg-transparent text-base font-normal text-[#999999] outline-none focus:outline-none placeholder-[#666666]" placeholder="Enter Last name" />
                </div>
            </div>
            <div class="w-full lg:w-1/3 flex flex-col gap-3.5">
                <label class="w-full font-semibold text-base" for="cean_contact_email">
                    Email
                </label>
                <div class="w-full bg-[#1A1A1A] h-12 py-4 px-5">
                    <input type="email" name="_cean_contact_email" id="cean_contact_email" class="w-full h-full bg-transparent text-base font-normal text-[#999999] outline-none focus:outline-none placeholder-[#666666]" placeholder="Enter first name" />
                </div>
            </div>
        </div>
        <div class="w-full flex gap-5 lg:gap-7 flex-col lg:flex-row" >
            <div class="flex-col flex  gap-3.5 w-full lg:w-1/3 ">
                <label class="w-full font-semibold text-base" for="cean_contact_phone">
                    Phone Number
                </label>
                <div class="w-full flex gap-3 h-12">
                    <button
                            id="cean_countryDropdown"
                            type="button"
                            class="flex h-full items-center space-x-2 rounded-l-md bg-transparent px-3 py-2 text-sm"
                    >
                        <span id="cean_selectedFlag" class="text-xl fi inline-block h-4/5 aspect-square rounded-full"></span>
<!--                        <span id="cean_selectedCode">+1</span>-->
                        <svg
                                class="w-4 h-4 text-gray-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                        >
                            <path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    <input type="text" name="_cean_contact_phone"  id="cean_contact_phone" class="w-full h-full bg-[#1A1A1A] p-4 text-base font-normal text-[#999999] outline-none focus:outline-none placeholder-[#666666]" placeholder="Enter phone number" />
                    <div
                            id="cean_dropdownMenu"
                            class="absolute left-0 z-10 mt-12 w-56 rounded-md bg-secondary-black shadow-lg border border-gray-200 hidden"
                    >
                        <div class="max-h-60 overflow-auto">
                            <!-- Dropdown options will be inserted here by JavaScript -->

                        </div>
                        <label>
                            <input type="hidden"  name="_cean_contact_country" />
                        </label>
                    </div>
                </div>
            </div>
            <div class="flex-col flex gap-3.5 w-full lg:w-1/3 ">
                <label class="w-full font-semibold text-base" for="cean_inquiry_type">
                    Inquiry Type
                </label>
                <div class="w-full bg-[#1A1A1A] h-12 relative">
                    <select id="cean_inquiry_type"
                            name="_cean_contact_inquiry_type"
                            class="w-full h-full bg-transparent text-base font-normal text-[#999999] bg-secondary-black outline-none focus:outline-none placeholder-[#666666] appearance-none cursor-pointer px-5"
                            style="-webkit-appearance: none; -moz-appearance: none;">
                        <?php foreach (CeanWP_Functions::get_inquiry_type() as $inquiry_type) : ?>
                            <option value="<?php echo esc_attr($inquiry_type); ?>">
                                <?php echo esc_html($inquiry_type); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <!-- Custom arrow indicator -->
                    <div class="absolute right-2 top-1/2 -translate-y-1/2 pointer-events-none">
                        <svg width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 1.5L6 6.5L11 1.5" stroke="#999999" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="flex-col flex gap-3.5 w-full lg:w-1/3 ">
                <label class="w-full font-semibold text-base" for="cean_contact_heard_about_us">
                    How Did You Hear About Us?
                </label>
                <div class="w-full bg-[#1A1A1A] h-12 relative">
                    <select id="cean_contact_heard_about_us"
                            name="_cean_contact_heard_about_us"
                            class="w-full h-full bg-transparent text-base font-normal text-[#999999] bg-secondary-black outline-none focus:outline-none placeholder-[#666666] appearance-none cursor-pointer px-5"
                            style="-webkit-appearance: none; -moz-appearance: none;">
                        <?php foreach (CeanWP_Functions::get_heard_about_us() as $inquiry_type) : ?>
                            <option value="<?php echo esc_attr($inquiry_type); ?>">
                                <?php echo esc_html($inquiry_type); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <!-- Custom arrow indicator -->
                    <div class="absolute right-2 top-1/2 -translate-y-1/2 pointer-events-none">
                        <svg width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 1.5L6 6.5L11 1.5" stroke="#999999" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-full">
            <div class="w-full flex flex-col gap-4">
                <label class="w-full font-semibold text-base" for="cean_contact_message">
                    Message
                </label>
                <div class="w-full bg-[#1A1A1A] h-40 py-4 px-5">
                    <textarea name="_cean_contact_message" id="cean_contact_message" class="w-full h-full bg-transparent text-base font-normal text-[#999999] outline-none focus:outline-none placeholder-[#666666]" placeholder="Enter message"></textarea>
                </div>
            </div>
        </div>
        <div class="w-full flex gap-5 lg:gap-0 lg:justify-between flex-col lg:flex-row">
            <div class="flex items-end">
                <div class="w-full h-6 flex items-center">
                        <input type="checkbox" name="cean_contact_form" id="cean_contact_agree" class="h-full aspect-square bg-transparent" />
                        <label class="font-normal text-base text-[#999999] ml-2" for="cean_contact_agree">
                            I agree with Terms of Use and Privacy Policy
                        </label>
                </div>
            </div>
            <button class="bg-primary-green font-normal text-sm py-3.5 px-8 rounded-lg" type="submit">
                Send Your Message
            </button>
        </div>
    </form>
</div>