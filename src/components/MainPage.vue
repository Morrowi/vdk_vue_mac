<template>
  <main :class="{ 'is_media': is_media}">
    <div class="row ">
      <div class="col text-center">
        <h1>{{title_h1}}</h1>
        <div class="sub_title">{{sub_title_h1}}</div>
      </div>
    </div>
    <div class="row" v-if="currentStep === 'main'">
      <div class="col-12 col-sm-6">
        <div class="warp_block_1 d-flex flex-column">
          <div class="warp_head d-flex">
            <img src="../assets/img/block_1_top_left.png" alt="">
            <img src="../assets/img/block_1_top_right.png" alt="">
          </div>
          <div class="title_block_1">Как представитель компании</div>
          <div class="sub_title_block_1">Оплата по реквизитам </div>
          <button class="bt" @click="goToStep('company');">Я представитель компании</button>
        </div>
      </div>
      <div class="col-12 col-sm-6">
        <div class="warp_block_1 warp_block_2 d-flex flex-column">
          <div class="warp_head d-flex">
            <img src="../assets/img/block_1_1_top_left.png" alt="">
            <img src="../assets/img/block_1_1_top_center.png" alt="">
            <img src="../assets/img/block_1_1_top_right.png" alt="">
          </div>
          <div class="title_block_1">Как частное лицо</div>
          <div class="sub_title_block_1">Оплата банковской картой</div>
          <button class="bt" @click="goToStep('private_person');">Я частное лицо</button>
        </div>
      </div>
      <div class="d-flex justify-content-center warp_btn_back">
        <a class="bt2" href="https://karelforum.ru/">Назад</a>
      </div>
    </div>
    <div class="row screen_2" v-if="currentStep === 'company'">
      <div class="col-12 col-lg-6">
        <div class="warp_block_1 d-flex flex-column">
          <div class="warp_head d-flex">
            <img src="../assets/img/screen2/screen_2_block_1_top_left.png" alt="">
          </div>
          <div class="title_block_1">Билет на один день форума</div>
          <div class="sub_title_block_1">3 200 руб <br>за посетителя</div>
          <button class="bt" @click="goToStep('company_one_day');">Оформить</button>
        </div>
      </div>
      <div class="col-12 col-lg-6">
        <div class="warp_block_1 warp_block_2 d-flex flex-column">
          <div class="warp_head d-flex">
            <img src="../assets/img/screen2/screen_2_block_1_top_right.png" alt="">
          </div>
          <div class="title_block_1">Полный билет</div>
          <div class="sub_title_block_1">9 800 руб <br>за посетителя</div>
          <button class="bt" @click="goToStep('company_full_day');">Оформить</button>
        </div>
      </div>
      <div class="d-flex justify-content-center warp_btn_back">
        <button class="bt2" @click="goToStep('main');">Назад</button>
      </div>
    </div>
    <div class="row screen_3" v-if="currentStep === 'company_one_day'">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="media_left">
            <div class="warp_head_screen_3">
              <div class="text">
                Билет на один день форума
              </div>
              <img src="../assets/img/screen3/screen_3.png" alt="">
            </div>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="media_left">
            <div class="warp_selected_date_screen_3">
              <div class="title">Выберите дату посещения:</div>
              <div class="warp_radio_button d-flex">
                <div class="form_radio">
                  <input id="radio-0" type="radio" name="date" value="22.05" checked v-model="dateSelected">
                  <label for="radio-0">22.05</label>
                </div>
                <div class="form_radio">
                  <input id="radio-1" type="radio" name="date" value="23.05"  v-model="dateSelected">
                  <label for="radio-1">23.05</label>
                </div>
                <div class="form_radio">
                  <input id="radio-2" type="radio" name="date" value="24.05" v-model="dateSelected">
                  <label for="radio-2">24.05 </label>
                </div>
                <div class="form_radio">
                  <input id="radio-3" type="radio" name="date" value="25.05" v-model="dateSelected">
                  <label for="radio-3">25.05</label>
                </div>
                <div class="form_radio">
                  <input id="radio-4" type="radio" name="date" value="26.05" v-model="dateSelected">
                  <label for="radio-4">26.05</label>
                </div>
              </div>
              <div class="text_info_date_bottom">
                22 мая — выезды на карьеры габбро-диабаза <br>
                23 мая — открытие выставки, образовательная программа, выезды на производства <br>
                24-25 мая — выставка и образовательная программа, выезды на производства <br>
                26 мая — закрытие выставки, образовательная программа, выезды на карьеры габбро-диабаза
              </div>
            </div>
          </div>
        </div>
        <form @submit="onSubmit">
          <div class="row justify-content-center">
            <div class="media_left">
              <div class="warp_selected_date_screen_3">
                <div class="title">Укажите данные всех участников</div>

                  <div class="row">
                    <div class="col-12 col-lg-6 d-flex flex-column mb-4 position-relative" v-for="(item, index) in participant" :key="index">
                      <span class="removeParticipant" :class="{hidden: index == 1 }" @click="removeParticipant(index);">Удалить участника <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" clip-rule="evenodd" d="M0.646444 1.35355C0.451182 1.15829 0.451182 0.841709 0.646444 0.646447C0.841707 0.451185 1.15829 0.451185 1.35355 0.646447L5 4.29289L8.64645 0.646447C8.84171 0.451185 9.15829 0.451185 9.35355 0.646447C9.54881 0.841709 9.54881 1.15829 9.35355 1.35355L5.7071 5L9.35355 8.64645C9.54881 8.84171 9.54881 9.15829 9.35355 9.35355C9.15829 9.54882 8.84171 9.54882 8.64644 9.35355L5 5.70711L1.35355 9.35355C1.15829 9.54882 0.841707 9.54882 0.646445 9.35355C0.451183 9.15829 0.451183 8.84171 0.646445 8.64645L4.29289 5L0.646444 1.35355Z" fill="#2F7135"/>
  </svg></span>
                      <div class="warp_input" v-for="input in item" :key="input.name">
                        <input class="formInput" :name="'user['+index+']['+input.name+']'" :placeholder="input.placeholder" type="text" :required="input.validate" />
                      </div>
                    </div>
                  </div>
              </div>
            </div>
          </div>
          <div class="row justify-content-center">
            <div class="media_left">
              <div class="ms-5">
                <button class="bt" @click="addMember();"><span><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M6.06665 13.0667C6.06665 13.5821 6.48452 14 6.99998 14C7.51545 14 7.93332 13.5821 7.93332 13.0667L7.93332 7.93356H13.0667C13.5821 7.93356 14 7.51569 14 7.00023C14 6.48476 13.5821 6.06689 13.0667 6.06689H7.93332L7.93332 0.933333C7.93332 0.417868 7.51545 0 6.99998 0C6.48452 0 6.06665 0.417867 6.06665 0.933333L6.06665 6.06689H0.933333C0.417868 6.06689 0 6.48476 0 7.00023C0 7.51569 0.417868 7.93356 0.933333 7.93356H6.06665L6.06665 13.0667Z" fill="white"/></svg></span> Добавить участника</button>
              </div>
            </div>
          </div>
          <div class="row justify-content-center">
            <div class="media_left">
              <div class="warp_selected_date_screen_3">
                <div class="text-2"> В стоимость билета входит посещение выставки, образовательной программы, экскурсии на карьеры, заводы и производства в выбранный день, а также скидка 10% на туристические услуги КарелфорумТур. Счет будет выслан на указанный адрес электронной почты. После оплаты на этот же адрес будет отправлен билет и подробности о скидке.
                  <a target="_blank" href="https://karelforum.ru/raspisanie">ознакомиться здесь</a></div>

                <div class="row">
                  <div class="warp_input">
                    <input class="formInput" name="phone"   placeholder="Телефон *" type="text" required />
                  </div>
                  <div class="warp_input">
                    <input class="formInput" name="email" placeholder="Эл. почта*" type="email" required />
                  </div>
                  <div class="warp_input">
                    <input class="formInput" v-model="cupon" name="promo" autocomplete="off" placeholder="Введите промокод (если есть)" type="text" />
                  </div>
                </div>
                <div class="row">
                  <div class="price">
                    Базовая стоимость: <span>{{showPrice}} руб</span>
                  </div>
                  <div class="price" v-if="showDicount">
                    Скидка по промокоду -10%: <span>{{priceDiscound}} руб</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row justify-content-center">
            <div class="media_left">
              <div class="warp_selected_date_screen_3 warp_requzit">
                <div class="row">
                  <div class="col-12 col-lg-6">
                    <div class="warp_input">
                      <input class="formInput" name="name_organiz" placeholder="Название организации*" type="text" required />
                    </div>

                    <div class="warp_input">
                      <input class="formInput" name="ogrn" placeholder="ОГРН (ИП)*" :value="ogrn" v-mask="'#############'" type="text" required />
                    </div>
                    <div class="warp_input">
                      <input class="formInput" name="gen_dir" placeholder="Генеральный директор*" :value="management" type="text" required />
                    </div>
                    <div class="warp_input">
                      <input class="formInput" name="rascetni_schet" placeholder="Рассчетный счет*" v-mask="'### ## ### # #### #######'" type="text" required />
                    </div>
                  </div>
                  <div class="col-12 col-lg-6">
                    <div class="warp_input">
                      <input class="formInput" name="inn" placeholder="ИНН*" :value="inn"  type="text" required />
                    </div>
                    <div class="warp_input">
                      <input class="formInput" name="bik" placeholder="БИК*" v-mask="'## ## ## ###'"   type="text" required />
                    </div>
                    <div class="warp_input">
                      <input class="formInput" name="kpp" placeholder="КПП" :value="kpp" v-mask="'## ## ## ###'" type="text"  />
                    </div>
                    <div class="warp_input">
                      <input class="formInput" name="kor_schet" placeholder="Корреспондентский счет*" v-mask="'####################'" type="text" required />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row justify-content-center">
            <div class="media_left">
              <div class="ms-5">
                <div class="form_checkbox">
                  <input id="soglasie-1" type="checkbox" name="soglasie" required>
                  <label for="soglasie-1">Соглашаюсь с обработкой персональных данных</label>
                </div>
              </div>
              <div class="d-flex justify-content-center warp_btn_back justify-content-between px-4">
                <button class="bt" type="submit">Отправить</button>
                <button class="bt2" @click="goToStep('company');">Назад</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="row screen_4" v-if="currentStep === 'company_full_day'">
      <div class="container-fluid">
        <div class="row  justify-content-center">
          <div class="media_left">
            <div class="warp_head_screen_3">
              <div class="text">
                Полный билет на форум
              </div>
              <img src="../assets/img/screen4/screen_4.png" alt="">
            </div>
          </div>
        </div>
        <form @submit="onSubmit">
        <div class="row justify-content-center">
          <div class="media_left">
            <div class="warp_selected_date_screen_3">
              <div class="warp_radio_button d-flex">
                Посещение с 22.05.23 по 26.05.23 включительно
              </div>
              22 мая — выезды на карьеры габбро-диабаза <br>
              23 мая — открытие выставки, образовательная программа, выезды на производства <br>
              24-25 мая — выставка и образовательная программа, выезды на производства <br>
              26 мая — закрытие выставки, образовательная программа, выезды на карьеры габбро-диабаза <br>

            </div>
            <div class="warp_selected_date_screen_3">
              <div class="title">Укажите данные всех участников</div>

              <div class="row">
                <div class="col-12 col-lg-6 d-flex flex-column mb-4 position-relative" v-for="(item, index) in participant" :key="index">
                  <span class="removeParticipant" :class="{hidden: index == 1 }" @click="removeParticipant(index);">Удалить участника <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" clip-rule="evenodd" d="M0.646444 1.35355C0.451182 1.15829 0.451182 0.841709 0.646444 0.646447C0.841707 0.451185 1.15829 0.451185 1.35355 0.646447L5 4.29289L8.64645 0.646447C8.84171 0.451185 9.15829 0.451185 9.35355 0.646447C9.54881 0.841709 9.54881 1.15829 9.35355 1.35355L5.7071 5L9.35355 8.64645C9.54881 8.84171 9.54881 9.15829 9.35355 9.35355C9.15829 9.54882 8.84171 9.54882 8.64644 9.35355L5 5.70711L1.35355 9.35355C1.15829 9.54882 0.841707 9.54882 0.646445 9.35355C0.451183 9.15829 0.451183 8.84171 0.646445 8.64645L4.29289 5L0.646444 1.35355Z" fill="#2F7135"/>
  </svg></span>
                  <div class="warp_input" v-for="input in item" :key="input.name">
                    <!--                      <input class="formInput" :name="'user['+index+']['+input.name+']'" :placeholder="input.placeholder" type="text" :required="input.validate" />-->
                    <input class="formInput" :name="'user['+index+']['+input.name+']'" :placeholder="input.placeholder" type="text" :required="input.validate" />
                  </div>
                </div>
              </div>
            </div>
            <div class="ms-5">
              <button class="bt" @click="addMember();"><span><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M6.06665 13.0667C6.06665 13.5821 6.48452 14 6.99998 14C7.51545 14 7.93332 13.5821 7.93332 13.0667L7.93332 7.93356H13.0667C13.5821 7.93356 14 7.51569 14 7.00023C14 6.48476 13.5821 6.06689 13.0667 6.06689H7.93332L7.93332 0.933333C7.93332 0.417868 7.51545 0 6.99998 0C6.48452 0 6.06665 0.417867 6.06665 0.933333L6.06665 6.06689H0.933333C0.417868 6.06689 0 6.48476 0 7.00023C0 7.51569 0.417868 7.93356 0.933333 7.93356H6.06665L6.06665 13.0667Z" fill="white"/></svg></span> Добавить участника</button>
            </div>
          </div>
        </div>
        <div class="row  justify-content-center">
          <div class="media_left">
            <div class="warp_selected_date_screen_3">
              <div class="text-2">В стоимость билета входит посещение выставки, образовательной программы, экскурсии на карьеры, заводы и производства, а также скидка 10% на туристические услуги КарелфорумТур. Счет будет выслан на указанный адрес электронной почты. После оплаты на этот же адрес будет отправлен билет и подробности о скидке.
                <a target="_blank" href="https://karelforum.ru/raspisanie">ознакомиться здесь</a></div>
              <div class="row">
                <div class="warp_input">
                  <input class="formInput" name="phone"   placeholder="Телефон *" type="text" required />
                </div>
                <div class="warp_input">
                  <input class="formInput" name="email" placeholder="Эл. почта*" type="email" required />
                </div>
                <div class="warp_input">
                  <input class="formInput" v-model="cupon" name="promo" placeholder="Введите промокод (если есть)" type="text" />
                </div>
              </div>
              <div class="row">
                <div class="price">
                  Базовая стоимость: <span>{{showPrice}} руб</span>
                </div>
                <div class="price" v-if="showDicount">
                  Скидка по промокоду -10%: <span>{{priceDiscound}} руб</span>
                </div>
              </div>
            </div>
          </div>

        </div>
        <div class="row  justify-content-center">
          <div class="media_left">
              <div class="warp_selected_date_screen_3 warp_requzit">
                <div class="row">
                  <div class="col-12 col-lg-6">
                    <div class="warp_input">
                      <input class="formInput" name="name_organiz" placeholder="Название организации*" type="text" required />
                    </div>

                    <div class="warp_input">
                      <input class="formInput" name="ogrn" placeholder="ОГРН (ИП)*" :value="ogrn" v-mask="'#############'" type="text" required />
                    </div>
                    <div class="warp_input">
                      <input class="formInput" name="gen_dir" placeholder="Генеральный директор*" :value="management" type="text" required />
                    </div>
                    <div class="warp_input">
                      <input class="formInput" name="rascetni_schet" placeholder="Рассчетный счет*" v-mask="'### ## ### # #### #######'" type="text" required />
                    </div>
                  </div>
                  <div class="col-12 col-lg-6">
                    <div class="warp_input">
                      <input class="formInput" name="inn" placeholder="ИНН*" :value="inn"  type="text" required />
                    </div>
                    <div class="warp_input">
                      <input class="formInput" name="bik" placeholder="БИК*" v-mask="'## ## ## ###'"   type="text" required />
                    </div>
                    <div class="warp_input">
                      <input class="formInput" name="kpp" placeholder="КПП" :value="kpp" v-mask="'## ## ## ###'" type="text"  />
                    </div>
                    <div class="warp_input">
                      <input class="formInput" name="kor_schet" placeholder="Корреспондентский счет*" v-mask="'####################'" type="text" required />
                    </div>
                  </div>
                </div>
              </div>
            </div>

        </div>
        <div class="row  justify-content-center">
            <div class="media_left">
              <div class="ms-5">
                <div class="form_checkbox">
                  <input id="soglasie-2" type="checkbox" name="soglasie" required>
                  <label for="soglasie-2">Соглашаюсь с обработкой персональных данных</label>
                </div>
              </div>
              <div class="d-flex justify-content-center warp_btn_back justify-content-between px-4">
                <button class="bt" type="submit">Отправить</button>
                <button class="bt2" @click="goToStep('company');">Назад</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="row  screen_5" v-if="currentStep === 'private_person'">
      <div class="col-12 col-lg-4">
        <div class="warp_block_1 d-flex flex-column">
          <div class="warp_head d-flex">
            <img src="../assets/img/screen5/screen_5_top_left.png" alt="">
          </div>
          <div class="title_block_1">Билет на один день форума</div>
          <div class="sub_title_block_1">2 800 руб <br>за посетителя</div>
          <button class="bt" @click="goToStep('private_one_day');">Оформить</button>
        </div>
      </div>
      <div class="col-12 col-lg-4">
        <div class="warp_block_1 warp_block_2 warp_block_2 d-flex flex-column">
          <div class="warp_head d-flex">
            <img src="../assets/img/screen5/screen_5_top_center.png" alt="">
          </div>
          <div class="title_block_1">Билет на все дни</div>
          <div class="sub_title_block_1">8 800 руб <br>за посетителя</div>
          <button class="bt" @click="goToStep('private_full_day');">Оформить</button>
        </div>
      </div>
      <div class="col-12 col-lg-4">
        <div class="warp_block_1 warp_block_3 d-flex flex-column">
          <div class="warp_head d-flex">
            <img src="../assets/img/screen5/screen_5_top_right.png" alt="">
          </div>
          <div class="title_block_1">Льготный билет для студентов (до 23 лет)</div>
          <div class="sub_title_block_1">2 000 руб <br>за посетителя</div>
          <button class="bt" @click="goToStep('private_stud_full_day');">Оформить</button>
        </div>
      </div>
      <div class="d-flex justify-content-center warp_btn_back">
        <button class="bt2" @click="goToStep('main');">Назад</button>
      </div>
    </div>
    <div class="row screen_6" v-if="currentStep === 'private_one_day'">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="media_left">
            <div class="warp_head_screen_3">
              <div class="text">
                Билет на один день форума
              </div>
              <img src="../assets/img/screen6/screen_6.png" alt="">
            </div>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="media_left">
            <div class="warp_selected_date_screen_3">
              <div class="title">Выберите дату посещения:</div>
              <div class="warp_radio_button d-flex">
                <div class="form_radio">
                  <input id="radio_private-0" type="radio" name="date" value="22.05" checked v-model="dateSelected">
                  <label for="radio_private-0">22.05</label>
                </div>
                <div class="form_radio">
                  <input id="radio_private-1" type="radio" name="date" value="23.05"  v-model="dateSelected">
                  <label for="radio_private-1">23.05</label>
                </div>
                <div class="form_radio">
                  <input id="radio_private-2" type="radio" name="date" value="24.05" v-model="dateSelected">
                  <label for="radio_private-2">24.05 </label>
                </div>
                <div class="form_radio">
                  <input id="radio_private-3" type="radio" name="date" value="25.05" v-model="dateSelected">
                  <label for="radio_private-3">25.05</label>
                </div>
                <div class="form_radio">
                  <input id="radio_private-4" type="radio" name="date" value="16.05" v-model="dateSelected">
                  <label for="radio_private-4">26.05</label>
                </div>
              </div>
              22 мая — выезды на карьеры габбро-диабаза <br>
              23 мая — открытие выставки, образовательная программа, выезды на производства <br>
              24-25 мая — выставка и образовательная программа, выезды на производства <br>
              26 мая — закрытие выставки, образовательная программа, выезды на карьеры габбро-диабаза <br>

            </div>
          </div>
        </div>
        <form @submit="onSubmit">
          <div class="row justify-content-center">
            <div class="media_left">
              <div class="warp_selected_date_screen_3">
                <div class="title">Укажите данные всех участников</div>

                <div class="row">
                  <div class="col-12 col-lg-6 d-flex flex-column mb-4 position-relative" v-for="(item, index) in participant" :key="index">
                    <span class="removeParticipant" :class="{hidden: index == 1 }" @click="removeParticipant(index);">Удалить участника <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" clip-rule="evenodd" d="M0.646444 1.35355C0.451182 1.15829 0.451182 0.841709 0.646444 0.646447C0.841707 0.451185 1.15829 0.451185 1.35355 0.646447L5 4.29289L8.64645 0.646447C8.84171 0.451185 9.15829 0.451185 9.35355 0.646447C9.54881 0.841709 9.54881 1.15829 9.35355 1.35355L5.7071 5L9.35355 8.64645C9.54881 8.84171 9.54881 9.15829 9.35355 9.35355C9.15829 9.54882 8.84171 9.54882 8.64644 9.35355L5 5.70711L1.35355 9.35355C1.15829 9.54882 0.841707 9.54882 0.646445 9.35355C0.451183 9.15829 0.451183 8.84171 0.646445 8.64645L4.29289 5L0.646444 1.35355Z" fill="#2F7135"/>
  </svg></span>
                    <div class="warp_input" v-for="input in item" :key="input.name">
                      <!--                      <input class="formInput" :name="'user['+index+']['+input.name+']'" :placeholder="input.placeholder" type="text" :required="input.validate" />-->
                      <input class="formInput" :name="'user['+index+']['+input.name+']'" :placeholder="input.placeholder" type="text" :required="input.validate" />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row justify-content-center">
            <div class="media_left">
              <div class="ms-5">
                <button class="bt" @click="addMember();"><span><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M6.06665 13.0667C6.06665 13.5821 6.48452 14 6.99998 14C7.51545 14 7.93332 13.5821 7.93332 13.0667L7.93332 7.93356H13.0667C13.5821 7.93356 14 7.51569 14 7.00023C14 6.48476 13.5821 6.06689 13.0667 6.06689H7.93332L7.93332 0.933333C7.93332 0.417868 7.51545 0 6.99998 0C6.48452 0 6.06665 0.417867 6.06665 0.933333L6.06665 6.06689H0.933333C0.417868 6.06689 0 6.48476 0 7.00023C0 7.51569 0.417868 7.93356 0.933333 7.93356H6.06665L6.06665 13.0667Z" fill="white"/></svg></span> Добавить участника</button>
              </div>
            </div>
          </div>
          <div class="row justify-content-center">
            <div class="media_left">
              <div class="warp_selected_date_screen_3">
                <div class="text-2">В стоимость билета входит посещение выставки, образовательной программы, экскурсии на карьеры, заводы и производства в выбранный день, а также скидка 10% на туристические услуги КарелфорумТур. Подробности о скидке будут высланы на ваш электронный адрес вместе с билетом.
                  <a target="_blank" href="https://karelforum.ru/raspisanie">ознакомиться здесь</a></div>

                <div class="row">
                  <div class="warp_input">
                    <input class="formInput" name="phone"   placeholder="Телефон *" type="text" required />
                  </div>
                  <div class="warp_input">
                    <input class="formInput" name="email" placeholder="Эл. почта*" type="email" required />
                  </div>
                  <div class="warp_input">
                    <input class="formInput" v-model="cupon" name="promo" placeholder="Введите промокод (если есть)" type="text" />
                  </div>
                </div>
                <div class="row">
                  <div class="price">
                    Базовая стоимость: <span>{{showPrice}} руб</span>
                  </div>
                  <div class="price" v-if="showDicount">
                    Скидка по промокоду -10%: <span>{{priceDiscound}} руб</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row justify-content-center">
            <div class="media_left">
              <div class="ms-5">
                <div class="form_checkbox">
                  <input id="soglasie-3" type="checkbox" name="soglasie" required>
                  <label for="soglasie-3">Соглашаюсь с обработкой персональных данных</label>
                </div>
              </div>
              <div class="d-flex justify-content-center warp_btn_back justify-content-between px-4">
                <button class="bt" type="submit" :disabled="loading"><span v-show="loading" class="spinner-border spinner-border-sm"></span>Отправить</button>
                <button class="bt2" @click="goToStep('private_person');">Назад</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="row screen_7" v-if="currentStep === 'private_full_day'">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="media_left">
            <div class="warp_head_screen_3">
              <div class="text">
                Билет на все дни
              </div>
              <img src="../assets/img/screen7/screen_7.png" alt="">
            </div>
          </div>
        </div>
        <form @submit="onSubmit">
          <div class="row justify-content-center">
            <div class="media_left">
              <div class="warp_selected_date_screen_3">
                <div class="warp_radio_button d-flex">
                  Посещение с 22.05.23 по 26.05.23 включительно
                </div>
                22 мая — выезды на карьеры габбро-диабаза <br>
                23 мая — открытие выставки, образовательная программа, выезды на производства <br>
                24-25 мая — выставка и образовательная программа, выезды на производства <br>
                26 мая — закрытие выставки, образовательная программа, выезды на карьеры габбро-диабаза <br>

              </div>
              <div class="warp_selected_date_screen_3">
                <div class="title">Укажите данные всех участников</div>

                <div class="row">
                  <div class="col-12 col-lg-6 d-flex flex-column mb-4 position-relative" v-for="(item, index) in participant" :key="index">
                    <span class="removeParticipant" :class="{hidden: index == 1 }" @click="removeParticipant(index);">Удалить участника <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" clip-rule="evenodd" d="M0.646444 1.35355C0.451182 1.15829 0.451182 0.841709 0.646444 0.646447C0.841707 0.451185 1.15829 0.451185 1.35355 0.646447L5 4.29289L8.64645 0.646447C8.84171 0.451185 9.15829 0.451185 9.35355 0.646447C9.54881 0.841709 9.54881 1.15829 9.35355 1.35355L5.7071 5L9.35355 8.64645C9.54881 8.84171 9.54881 9.15829 9.35355 9.35355C9.15829 9.54882 8.84171 9.54882 8.64644 9.35355L5 5.70711L1.35355 9.35355C1.15829 9.54882 0.841707 9.54882 0.646445 9.35355C0.451183 9.15829 0.451183 8.84171 0.646445 8.64645L4.29289 5L0.646444 1.35355Z" fill="#2F7135"/>
  </svg></span>
                    <div class="warp_input" v-for="input in item" :key="input.name">
                      <!--                      <input class="formInput" :name="'user['+index+']['+input.name+']'" :placeholder="input.placeholder" type="text" :required="input.validate" />-->
                      <input class="formInput" :name="'user['+index+']['+input.name+']'" :placeholder="input.placeholder" type="text" :required="input.validate" />
                    </div>
                  </div>
                </div>
              </div>
              <div class="ms-5">
                <button class="bt" @click="addMember();"><span><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M6.06665 13.0667C6.06665 13.5821 6.48452 14 6.99998 14C7.51545 14 7.93332 13.5821 7.93332 13.0667L7.93332 7.93356H13.0667C13.5821 7.93356 14 7.51569 14 7.00023C14 6.48476 13.5821 6.06689 13.0667 6.06689H7.93332L7.93332 0.933333C7.93332 0.417868 7.51545 0 6.99998 0C6.48452 0 6.06665 0.417867 6.06665 0.933333L6.06665 6.06689H0.933333C0.417868 6.06689 0 6.48476 0 7.00023C0 7.51569 0.417868 7.93356 0.933333 7.93356H6.06665L6.06665 13.0667Z" fill="white"/></svg></span> Добавить участника</button>
              </div>
            </div>
          </div>
          <div class="row justify-content-center">
            <div class="media_left">
              <div class="warp_selected_date_screen_3">
                <div class="text-2">В стоимость билета входит посещение выставки, образовательной программы, экскурсии карьеры, заводы и производства, а также скидка 10% на туристические услуги КарелфорумТур. Подробности о скидке будут высланы на ваш электронный адрес вместе с билетом.
                  <a target="_blank" href="https://karelforum.ru/raspisanie">ознакомиться здесь</a></div>
                <div class="row">
                  <div class="warp_input">
                    <input class="formInput" name="phone"   placeholder="Телефон *" type="text" required />
                  </div>
                  <div class="warp_input">
                    <input class="formInput" name="email" placeholder="Эл. почта*" type="email" required />
                  </div>
                  <div class="warp_input">
                    <input class="formInput" v-model="cupon" name="promo" placeholder="Введите промокод (если есть)" type="text" />
                  </div>
                </div>
                <div class="row">
                  <div class="price">
                    Базовая стоимость: <span>{{showPrice}} руб</span>
                  </div>
                  <div class="price" v-if="showDicount">
                    Скидка по промокоду -10%: <span>{{priceDiscound}} руб</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row justify-content-center">
            <div class="media_left">
              <div class="ms-5">
                <div class="form_checkbox">
                  <input id="soglasie-4" type="checkbox" name="soglasie" required>
                  <label for="soglasie-4">Соглашаюсь с обработкой персональных данных</label>
                </div>
              </div>
              <div class="d-flex justify-content-center warp_btn_back justify-content-between px-4">
                <button class="bt" type="submit" :disabled="loading"><span v-show="loading" class="spinner-border spinner-border-sm"></span>Отправить</button>
                <button class="bt2" @click="goToStep('private_person');">Назад</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="row screen_8" v-if="currentStep === 'private_stud_full_day'">
      <div class="container-fluid">
        <div class="row">
        <div class="media_left">
          <div class="warp_head_screen_3">
            <div class="text">
              Льготный билет для студентов до 23 лет
            </div>
            <img src="../assets/img/screen8/screen_8.png" alt="">
          </div>
        </div>
        <div class="media_right"></div>
      </div>
        <form @submit="onSubmit">
        <div class="row">
          <div class="media_left">
            <div class="warp_selected_date_screen_3">
              <div class="warp_radio_button d-flex">
                Посещение с 22.05.23 по 26.05.23 включительно
              </div>
              22 мая — выезды на карьеры габбро-диабаза <br>
              23 мая — открытие выставки, образовательная программа, выезды на производства <br>
              24-25 мая — выставка и образовательная программа, выезды на производства <br>
              26 мая — закрытие выставки, образовательная программа, выезды на карьеры габбро-диабаза

            </div>
            <div class="warp_selected_date_screen_3">
              <div class="title">Укажите данные всех участников</div>

              <div class="row">
                <div class="col-12 col-lg-6 d-flex flex-column mb-4 position-relative" v-for="(item, index) in participant" :key="index">
                  <span class="removeParticipant" :class="{hidden: index == 1 }" @click="removeParticipant(index);">Удалить участника <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M0.646444 1.35355C0.451182 1.15829 0.451182 0.841709 0.646444 0.646447C0.841707 0.451185 1.15829 0.451185 1.35355 0.646447L5 4.29289L8.64645 0.646447C8.84171 0.451185 9.15829 0.451185 9.35355 0.646447C9.54881 0.841709 9.54881 1.15829 9.35355 1.35355L5.7071 5L9.35355 8.64645C9.54881 8.84171 9.54881 9.15829 9.35355 9.35355C9.15829 9.54882 8.84171 9.54882 8.64644 9.35355L5 5.70711L1.35355 9.35355C1.15829 9.54882 0.841707 9.54882 0.646445 9.35355C0.451183 9.15829 0.451183 8.84171 0.646445 8.64645L4.29289 5L0.646444 1.35355Z" fill="#2F7135"/>
</svg></span>
                  <div class="warp_input" v-for="input in item" :key="input.name">
                    <!--                      <input class="formInput" :name="'user['+index+']['+input.name+']'" :placeholder="input.placeholder" type="text" :required="input.validate" />-->
                    <input class="formInput" :name="'user['+index+']['+input.name+']'" :placeholder="input.placeholder" type="text" :required="input.validate" />
                  </div>
                </div>
              </div>
            </div>
            <div class="ms-5 mb-20">
              <button class="bt" @click="addMember();"><span><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M6.06665 13.0667C6.06665 13.5821 6.48452 14 6.99998 14C7.51545 14 7.93332 13.5821 7.93332 13.0667L7.93332 7.93356H13.0667C13.5821 7.93356 14 7.51569 14 7.00023C14 6.48476 13.5821 6.06689 13.0667 6.06689H7.93332L7.93332 0.933333C7.93332 0.417868 7.51545 0 6.99998 0C6.48452 0 6.06665 0.417867 6.06665 0.933333L6.06665 6.06689H0.933333C0.417868 6.06689 0 6.48476 0 7.00023C0 7.51569 0.417868 7.93356 0.933333 7.93356H6.06665L6.06665 13.0667Z" fill="white"/></svg></span> Добавить участника</button>
            </div>
            <div class="warp_selected_date_screen_3">
              <div class="text-2">В стоимость билета входит посещение выставки, образовательной программы, экскурсии на карьеры, заводы и производства в выбранный день, а также скидка 10% на туристические услуги КарелфорумТур. Подробности о скидке будут высланы на ваш электронный адрес вместе с билетом.
                <a target="_blank" href="https://karelforum.ru/raspisanie">ознакомиться здесь</a></div>
              <div class="row">
                <div class="warp_input">
                  <input class="formInput" name="phone"   placeholder="Телефон *" type="text" required />
                </div>
                <div class="warp_input">
                  <input class="formInput" name="email" placeholder="Эл. почта*" type="email" required />
                </div>
                <div class="warp_input">
                  <input class="formInput" v-model="cupon" name="promo" placeholder="Введите промокод (если есть)" type="text" />
                </div>
              </div>
              <div class="row">
                <div class="price">
                  Базовая стоимость: <span>{{showPrice}} руб</span>
                </div>
                <div class="price" v-if="showDicount">
                  Скидка по промокоду -25%: <span>{{priceDiscound}} руб</span>
                </div>
              </div>
            </div>
            <div class="ms-5">
              <div class="form_checkbox">
                <input id="soglasie-5" type="checkbox" name="soglasie" required>
                <label for="soglasie-5">Соглашаюсь с обработкой персональных данных</label>
              </div>
            </div>
            <div class="d-flex justify-content-center warp_btn_back justify-content-between px-4">
              <button class="bt" type="submit" :disabled="loading"><span v-show="loading" class="spinner-border spinner-border-sm"></span>Отправить</button>
              <button class="bt2" @click="goToStep('private_person');">Назад</button>
            </div>
          </div>
          <div class="media_right">
            <div class="warp_info">
              <b>Важно:</b> для прохода на форум вместе с билетом вам необходимо предоставить действующий студенческий билет
            </div>
          </div>
        </div>


      </form>
      </div>
    </div>
  </main>
</template>

<script>
import {mask} from 'vue-the-mask'
import axios from 'axios'
export default {
  name: 'MainPage',
  components: {

  },
  directives: {mask},
  data() {
    return{
      loading: false,
      showDicount:false,
      priceDiscound:0,
      organization:'',
      organization_full:'',
      ogrn:'',
      management:'',
      inn:'',
      kpp:'',
      dateSelected:'22.05',
      title_h1:'Купить билет',
      sub_title_h1:'Вы хотите купить билет на Карелфорум как:',

      participant:{
        1:[{ 'name': 'name', 'placeholder': 'Имя *', 'validate':true },{ 'name': 'last_name', 'placeholder': 'Фамилия *', 'validate':true },{ 'name': 'second_name', 'placeholder': 'Отчество', 'validate':false }],
      },
      price:4000,
      allprice:4000,
      showPrice:'4 000',

      cupon:'',

      is_media:false,
      currentStep: 'main',
    }

  },


  methods: {

    goToStep(step) {

      this.$router.push({hash: '#' + step});

      //this.$router.go(-1);
      //window.history.pushState({}, null, this.$route.path);

      /*   console.log(step);
      // eslint-disable-next-line no-unused-vars
      let urlHistore="";
      if(step === 'main'){
        urlHistore='/';
      }  else {
        urlHistore=step;
      }*/
      //console.log(urlHistore);
      //window.history.pushState({}, null, '/'+urlHistore+'/');
      this.currentStep = step;
      switch (step) {
        case 'main':
          this.is_media = false;
          this.title_h1 = "Купить билет";
          this.sub_title_h1 = "Вы хотите купить билет на Карелфорум как:";
          break;
        case 'company':
          this.title_h1 = "Оформление билета для представителя компании";
          this.sub_title_h1 = "";
          this.is_media = false;
          this.organization = '';
          this.ogrn = '';
          this.management = '';
          this.inn = '';
          this.kpp = '';
          break;
        case 'company_one_day':
          this.is_media = true;
          this.title_h1 = "";
          this.sub_title_h1 = "";
          this.price = 3200;
          this.allprice = 3200;
          this.cupon = '';
          this.showPrice = this.price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
          this.participant = {
            1: [
              {'name': 'name', 'placeholder': 'Имя *', 'validate': true},
              {'name': 'last_name', 'placeholder': 'Фамилия *', 'validate': true},
              {'name': 'second_name', 'placeholder': 'Отчество', 'validate': false},
              {'name': 'company', 'placeholder': 'Компания', 'validate': false},
              {'name': 'job_title', 'placeholder': 'Должность', 'validate': false},
              {'name': 'city', 'placeholder': 'Город', 'validate': false}
            ],
          };
          break;
        case 'company_full_day':
          this.is_media = true;
          this.title_h1 = "";
          this.sub_title_h1 = "";
          this.price = 9800;
          this.allprice = 9800;
          this.cupon = '';
          this.showPrice = this.price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
          this.dateSelected = 'full';
          // this.price =this.price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
          this.participant = {
            1: [
              {'name': 'name', 'placeholder': 'Имя *', 'validate': true},
              {'name': 'last_name', 'placeholder': 'Фамилия *', 'validate': true},
              {'name': 'second_name', 'placeholder': 'Отчество', 'validate': false},
              {'name': 'company', 'placeholder': 'Компания', 'validate': false},
              {'name': 'job_title', 'placeholder': 'Должность', 'validate': false},
              {'name': 'city', 'placeholder': 'Город', 'validate': false}
            ],
          };
          break;
        case 'private_person':
          this.title_h1 = "Оформление билета для частного лица";
          this.sub_title_h1 = "";
          this.is_media = false;
          break;
        case 'private_one_day':
          this.is_media = true;
          this.title_h1 = "";
          this.sub_title_h1 = "";
          this.price = 2800;
          this.allprice = 2800;
          this.cupon = '';
          this.showPrice = this.price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
          this.participant = {
            1: [
              {'name': 'name', 'placeholder': 'Имя *', 'validate': true},
              {'name': 'last_name', 'placeholder': 'Фамилия *', 'validate': true},
              {'name': 'second_name', 'placeholder': 'Отчество', 'validate': false},
              {'name': 'company', 'placeholder': 'Компания', 'validate': false},
              {'name': 'job_title', 'placeholder': 'Должность', 'validate': false},
              {'name': 'city', 'placeholder': 'Город', 'validate': false}
            ],
          };
          break;
        case 'private_full_day':
          this.is_media = true;
          this.title_h1 = "";
          this.sub_title_h1 = "";
          this.price = 8800;
          this.allprice = 8800;
          this.cupon = '';
          this.showPrice = this.price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
          this.participant = {
            1: [
              {'name': 'name', 'placeholder': 'Имя *', 'validate': true},
              {'name': 'last_name', 'placeholder': 'Фамилия *', 'validate': true},
              {'name': 'second_name', 'placeholder': 'Отчество', 'validate': false},
              {'name': 'company', 'placeholder': 'Компания', 'validate': false},
              {'name': 'job_title', 'placeholder': 'Должность', 'validate': false},
              {'name': 'city', 'placeholder': 'Город', 'validate': false}
            ],
          };
          break;
        case 'private_stud_full_day':
          this.is_media = true;
          this.title_h1 = "";
          this.sub_title_h1 = "";
          this.price = 2000;
          this.allprice = 2000;
          this.cupon = '';
          this.showPrice = this.price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
          this.participant = {
            1: [
              {'name': 'name', 'placeholder': 'Имя *', 'validate': true},
              {'name': 'last_name', 'placeholder': 'Фамилия *', 'validate': true},
              {'name': 'second_name', 'placeholder': 'Отчество', 'validate': false}
            ],
          };
          break;
      }

    },
    onSubmit(event) {
      this.loading = true;
      event.preventDefault();


      let formData = new FormData(event.target);
      formData.append('date', this.dateSelected);
      formData.append('what', this.currentStep);
      formData.append('price', this.allprice);


//console.log(this);

      //console.log(this.showPrice.replace(/[^0-9]/g, ""));

      //console.log(this.allprice);

      axios.post("https://pay.karelforum.ru/post.php", formData)
          .then((response) => {
            let data = response.data;
            if (data.redirect == 0) {
              if (data.STATUS == 'SACCES') {
                //this.title_h1="Результат";
                //this.currentStep='finish';
                this.$router.push("/result");
                //console.log(1);
                this.loading = true;
              } else {
                alert('error');
              }
            } else {
              this.loading = true;
              //console.log(data);
              if (data.pay.status === 200) {

                window.location.href = data.pay.data.cardDataUrl;
              } else {
                alert(data.errorMessage);
              }
            }

          });


    },
    addMember() {
      let tmpKey = 0;
      for (let i in this.participant) {
        console.log(i);
        tmpKey++;
      }
      tmpKey = tmpKey + 1;

      let tmpPrice = this.price * tmpKey;
      this.allprice = this.price * tmpKey;
      //this.price =this.price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");//добавляем побел
      this.showPrice = new Intl.NumberFormat("ru", {style: "decimal"}).format(tmpPrice);
      if (this.currentStep === 'private_stud_full_day') {
        this.participant[tmpKey] = [
          {'name': 'name', 'placeholder': 'Имя *', 'validate': true},
          {'name': 'last_name', 'placeholder': 'Фамилия *', 'validate': true},
          {'name': 'second_name', 'placeholder': 'Отчество', 'validate': false}
        ];
      } else {
        this.participant[tmpKey] = [
          {'name': 'name', 'placeholder': 'Имя *', 'validate': true},
          {'name': 'last_name', 'placeholder': 'Фамилия *', 'validate': true},
          {'name': 'second_name', 'placeholder': 'Отчество', 'validate': false},
          {'name': 'company', 'placeholder': 'Компания', 'validate': false},
          {'name': 'job_title', 'placeholder': 'Должность', 'validate': false},
          {'name': 'city', 'placeholder': 'Город', 'validate': false}
        ];
      }

    },
    removeParticipant(i) {
      delete this.participant[i];
      //console.log();
    },
    goLinkStep() {

      let step = this.$route.hash;
      step = step.substr(1);
      this.goToStep(step);
    },
  },
  /*created (){
    onpopstate = function() {
      console.log(this);
      //this.goToStep(event.state.current);
      //console.log(event.state.current);
    }
    /!*window.onpopstate = function(event) {
      this.test(event.state.current);
      //console.log(event.state.current);
    };*!/

  },*/
  watch:{
    $route(to) {
      // if anything needs to be done when the route changes
     /* let step ='main';
      if(to.hash!==''){
        let step = to.hash;
      }*/
      //let step = to.hash;
      //this.goToStep(step);
      let step = to.hash;
      console.log('step --- '+to.hash);
      step = step.substr(1);
      console.log('to --- '+step);
      if(step===''){step='main';}
      this.goToStep(step);
    },
    organization_full(val){
      if(val!==null){
        console.log(val.data);
        let data = val.data;
        this.inn=data.inn;
        this.ogrn=data.ogrn;
        if(data.management !== undefined ){
          this.management=data.management.name;
        }
        this.kpp=data.kpp;
      }
    },
    cupon(val){
      let next = false;

      for (let i of this.$store.state.promos){
        if(i.code === val ){
          next = true;
        }
      }


      if(next){
        this.price= this.showPrice.replace(/\s+/g, function() {return '';});
        /*if(this.currentStep == 'company_one_day' || this.currentStep == 'private_one_day'){
          this.price=this.price-this.price/100*20;
        } else if(this.currentStep == 'private_stud_full_day'){
          this.price=this.price-this.price/100*25;
        } else {
          this.price=this.price-this.price/100*10;
        }*/
        this.price=this.price-this.price/100*10;
        this.allprice=this.price;
        this.priceDiscound = new Intl.NumberFormat("ru", {style: "decimal"}).format(this.price);
        this.showDicount=true;
      } else {
        this.showDicount=false;

        this.price= this.showPrice.replace(/\s+/g, function() {return '';});
        this.allprice=this.price;
      }

      if(val ==='morrowi'){
        this.price = 1;
        this.allprice = 1;
      }

    },
  },
  computed:{

  },
  mounted() {
    this.goLinkStep();
  }
}

</script>
