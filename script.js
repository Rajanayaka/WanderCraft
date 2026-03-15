let travelerCount  = 2;
let selectedDays   = 2;
let selectedPlaces = [];

function saveState(key, val) {
  try { localStorage.setItem('wc_' + key, JSON.stringify(val)); } catch (e) {}
}

function loadState(key, defaultVal) {
  try {
    const stored = localStorage.getItem('wc_' + key);
    return stored !== null ? JSON.parse(stored) : defaultVal;
  } catch (e) {
    return defaultVal;
  }
}

function loadAllState() {
  travelerCount  = loadState('travelers', 2);
  selectedDays   = loadState('days', 2);
  selectedPlaces = loadState('places', []);
}

const placesData = {
  cultural: [
    { id: 'c1', name: 'Temple of the Tooth',         hours: 2.5, category: 'Cultural',  icon: '🏯', color: 'gi-1', img: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQIu0FaGuddlQUJq6cQ4xGThc3yUOb-dPHzNg&s' },
    { id: 'c2', name: 'Kandy City Walk',              hours: 1.5, category: 'Cultural',  icon: '🎨', color: 'gi-2', img: 'https://media.tacdn.com/media/attractions-splice-spp-674x446/09/29/a9/bc.jpg' },
    { id: 'c3', name: 'Bahiravokanda Statue',         hours: 1.0, category: 'Religious', icon: '🙏', color: 'gi-5', img: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRRu_kzTon5L8v_V15x6UQz2UnGUoLNlM3oZQ&s' },
    { id: 'c4', name: 'Kandy Lake Walk',              hours: 1.0, category: 'Scenic',    icon: '🌊', color: 'gi-3', img: 'https://srilankaexplorers.com/wp-content/uploads/2024/05/1_UTMYLJ4O9xJS89SazTUBLw.jpg' },
    { id: 'c5', name: 'Embekka Devalaya',             hours: 2.0, category: 'Heritage',  icon: '⛩️', color: 'gi-6', img: 'https://www.tourslanka.com/wp-content/uploads/2018/06/Embekka-Devalaya-Entrance.jpg' },
    { id: 'c6', name: 'Lankatilaka Temple',           hours: 1.5, category: 'Heritage',  icon: '🕌', color: 'gi-4', img: 'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/19/83/7e/6a/very-old-temple-around.jpg?w=900&h=500&s=1' },
  ],
  nature: [
    { id: 'n1', name: 'Peradeniya Botanical Garden', hours: 3.0, category: 'Nature',    icon: '🌿', color: 'gi-2', img: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTSBzjOWPR_FjWScv_2GgZ0eZK85Zv6zwBVbw&s' },
    { id: 'n2', name: 'Victoria Dam',                 hours: 2.0, category: 'Scenic',    icon: '💧', color: 'gi-3', img: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ08_YUnpn9TzhrtwkhWFpPC8x6llp1F0D6Cw&s' },
    { id: 'n3', name: 'Knuckles Mountain',            hours: 4.0, category: 'Adventure', icon: '🏔️', color: 'gi-4', img: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRXNGqcvq4pABz5Of99s-wuoAg5wztyg59WZw&s' },
    { id: 'n4', name: 'Udawatta Kele Forest',         hours: 1.5, category: 'Nature',    icon: '🌳', color: 'gi-1', img: 'https://www.travelmapsrilanka.com/destinations/destinationimages/udawatta-kele-sanctuary-in-sri-lanka.webp' },
    { id: 'n5', name: 'Mahaweli River View',          hours: 1.0, category: 'Scenic',    icon: '🏞️', color: 'gi-5', img: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQLTUs97wtXhBuogyDCcOBdgKV8-LCkFm7eEQ&s' },
    { id: 'n6', name: 'Ambuluwawa Tower',             hours: 2.0, category: 'Adventure', icon: '🗼', color: 'gi-6', img: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTwLdJd-awXqddByX23NScJKL8_BeQrhJtVZg&s' },
  ]
};

const hotelsData = [
  { id: 'h1', name: 'Budget Inn Kandy',      loc: 'City Centre, Kandy',       price: '4,500',  cat: 'budget',   icon: '🏨', color: 'hi-1', img: 'https://digital.ihg.com/is/image/ihg/ihgor-member-rate-web-offers-1440x720?fit=crop,1&wid=1440&hei=720', amenities: ['WiFi', 'Breakfast', 'AC'],          reviewer: 'Kasun P.',   stars: 3, review: 'Clean rooms, great location near the temple. Good value!' },
  { id: 'h2', name: 'Kandy View Hotel',      loc: 'Lake View, Kandy',         price: '9,800',  cat: 'standard', icon: '🏩', color: 'hi-2', img: 'https://digital.ihg.com/is/image/ihg/ihgor-member-rate-web-offers-1440x720?fit=crop,1&wid=1440&hei=720', amenities: ['WiFi', 'Pool', 'Restaurant', 'AC'],  reviewer: 'Dilani S.',  stars: 4, review: 'Beautiful lake view from the room. Staff were incredibly helpful!' },
  { id: 'h3', name: 'The Golden Crown',      loc: 'Peradeniya Road, Kandy',   price: '22,000', cat: 'luxury',   icon: '🏰', color: 'hi-3', img: 'https://digital.ihg.com/is/image/ihg/ihgor-member-rate-web-offers-1440x720?fit=crop,1&wid=1440&hei=720', amenities: ['Pool', 'Spa', 'Fine Dining', 'Gym'], reviewer: 'Rajan M.',   stars: 5, review: 'Absolutely world-class experience. Worth every rupee!' },
  { id: 'h4', name: 'Green Leaf Guesthouse', loc: 'Katugastota, Kandy',       price: '3,800',  cat: 'budget',   icon: '🛏️', color: 'hi-4', img: 'https://digital.ihg.com/is/image/ihg/ihgor-member-rate-web-offers-1440x720?fit=crop,1&wid=1440&hei=720', amenities: ['WiFi', 'Garden', 'AC'],             reviewer: 'Amara K.',   stars: 3, review: 'Peaceful garden setting. Perfect for backpackers!' },
  { id: 'h5', name: 'Hotel Topaz',           loc: 'Sangaraja Mawatha, Kandy', price: '11,500', cat: 'standard', icon: '🏨', color: 'hi-5', img: 'https://digital.ihg.com/is/image/ihg/ihgor-member-rate-web-offers-1440x720?fit=crop,1&wid=1440&hei=720', amenities: ['WiFi', 'Restaurant', 'Bar', 'AC'],  reviewer: 'Nimal F.',   stars: 4, review: 'Central location, good food and very friendly staff!' },
  { id: 'h6', name: 'Amaya Hills Resort',    loc: 'Heerassagala, Kandy',      price: '35,000', cat: 'luxury',   icon: '🌟', color: 'hi-6', img: 'https://digital.ihg.com/is/image/ihg/ihgor-member-rate-web-offers-1440x720?fit=crop,1&wid=1440&hei=720', amenities: ['Pool', 'Spa', 'Gym', 'Helipad'],    reviewer: 'Shanthi R.', stars: 5, review: 'Breathtaking hilltop views. The spa is truly exceptional!' },
];

function timeFmt(h, m, p) {
  return h + ':' + (m < 10 ? '0' + m : m) + ' ' + p;
}

function timeAdvance(h, m, p, hrs) {
  let baseH = (p === 'PM' && h !== 12) ? h + 12 : (p === 'AM' && h === 12) ? 0 : h;
  let total = baseH * 60 + m + Math.round(hrs * 60);
  total = total % 1440;
  let nh = Math.floor(total / 60) % 24;
  let nm = total % 60;
  let np = nh < 12 ? 'AM' : 'PM';
  if (nh === 0) nh = 12;
  else if (nh > 12) nh -= 12;
  return [nh, nm, np];
}

function timeEnd(h, m, p, hrs) {
  return timeFmt(...timeAdvance(h, m, p, hrs));
}

let sliderIdx   = 0;
const totalSlides = 5;

function nextSlide() {
  sliderIdx = (sliderIdx + 1) % totalSlides;
  updateSlider();
}

function prevSlide() {
  sliderIdx = (sliderIdx - 1 + totalSlides) % totalSlides;
  updateSlider();
}

function goSlide(idx) {
  sliderIdx = idx;
  updateSlider();
}

function updateSlider() {
  var track = document.getElementById('slider-track');
  if (!track) return;
  track.style.transform = 'translateX(-' + (sliderIdx * 100) + '%)';
  document.querySelectorAll('.wc-dot').forEach(function (dot, i) {
    dot.classList.toggle('active-dot-s', i === sliderIdx);
  });
}

function animateProgressBars() {
  document.querySelectorAll('.wc-progress-fill').forEach(function (bar) {
    var target = bar.getAttribute('data-width');
    if (!target) return;
    bar.style.width = '0%';
    setTimeout(function () { bar.style.width = target; }, 400);
  });
}

function changeCount(delta) {
  travelerCount = Math.max(1, Math.min(20, travelerCount + delta));
  var el = document.getElementById('traveler-count');
  if (el) el.textContent = travelerCount;
  saveState('travelers', travelerCount);
  updatePreview();
}

function selectDays(el, days) {
  selectedDays = days;
  document.querySelectorAll('.wc-pill').forEach(function (p) {
    p.classList.remove('active-pill');
  });
  el.classList.add('active-pill');
  saveState('days', selectedDays);
  updatePreview();
}


function updatePreview() {
  var destEl = document.getElementById('inp-dest');
  var dateEl = document.getElementById('inp-date');
  if (!destEl) return;

  var dest    = destEl.value.trim() || 'your destination';
  var dateVal = dateEl ? dateEl.value : '';
  var hours   = selectedDays * 8;
  var label   = selectedDays === 1 ? '1-day' : selectedDays + '-day';

  function setText(id, val) {
    var e = document.getElementById(id);
    if (e) e.textContent = val;
  }

  setText('lp-days',      label);
  setText('lp-dest',      dest);
  setText('lp-travelers', travelerCount);
  setText('lp-hours',     hours + 'h');
  setText('lp-date',      dateVal || 'Not set');
}


function addTag() {
  var name = prompt('Enter a place name:');
  if (!name || !name.trim()) return;
  var container = document.getElementById('tags-container');
  var addBtn    = container.querySelector('.wc-tag-add');
  var tag       = document.createElement('span');
  tag.className = 'wc-tag';
  tag.innerHTML = name.trim() + ' <span onclick="removeTag(this)">✕</span>';
  container.insertBefore(tag, addBtn);
}

function removeTag(el) {
  el.parentElement.remove();
}

function goToReco() {
  var valid = true;

  var dest  = document.getElementById('inp-dest').value.trim();
  var errD  = document.getElementById('err-dest');
  if (!dest) {
    errD.classList.remove('d-none');
    valid = false;
  } else {
    errD.classList.add('d-none');
  }

  var date  = document.getElementById('inp-date').value;
  var errDt = document.getElementById('err-date');
  if (!date) {
    errDt.classList.remove('d-none');
    valid = false;
  } else {
    errDt.classList.add('d-none');
  }

  if (valid) {
    saveState('destination', dest);
    saveState('date', date);
    saveState('travelers', travelerCount);
    saveState('days', selectedDays);
    saveState('places', []);
    selectedPlaces = [];
    window.scrollTo({ top: 0, behavior: 'smooth' });
    setTimeout(function () {
      window.location.href = 'destinations.html';
    }, 200);
  }
}


function renderPlaceCards() {
  var container = document.getElementById('cultural-cards');
  if (!container) return;

  var dest  = loadState('destination', 'Kandy');
  var days  = loadState('days', 2);
  var hours = days * 8;

  function setText(id, val) {
    var e = document.getElementById(id);
    if (e) e.textContent = val;
  }

  setText('tb-dest',    dest);
  setText('tb-days',    days + ' Days');
  setText('tb-hours',   hours + ' Hours');
  setText('warn-hours', hours + ' hours');

  renderCategory('cultural-cards', placesData.cultural);
  renderCategory('nature-cards',   placesData.nature);
  updateSelectionFooter();
}

function renderCategory(containerId, places) {
  var container = document.getElementById(containerId);
  if (!container) return;
  container.innerHTML = '';

  places.forEach(function (place) {
    var isSel = selectedPlaces.some(function (p) { return p.id === place.id; });
    var col   = document.createElement('div');
    col.className = 'col-md-4 col-sm-6';
    col.innerHTML =
      '<div class="wc-place-card ' + (isSel ? 'selected' : '') + '" id="card-' + place.id + '" onclick="togglePlace(\'' + place.id + '\')">' +
        '<div class="wc-place-img">' +
          '<img src="' + place.img + '" alt="' + place.name + '" style="width:100%;height:100%;object-fit:cover;"/>' +
          '<div class="wc-place-check">✓</div>' +
        '</div>' +
        '<div class="wc-place-body">' +
          '<div class="wc-place-name">' + place.name + '</div>' +
          '<div class="wc-place-meta">' +
            '<span class="wc-place-m">⏱️ ' + place.hours + ' hrs</span>' +
            '<span class="wc-place-m">🏷️ ' + place.category + '</span>' +
          '</div>' +
          '<button class="wc-details-btn ' + (isSel ? 'selected-btn' : '') + '" id="btn-' + place.id + '">' +
            (isSel ? '✓ Selected' : 'Details') +
          '</button>' +
        '</div>' +
      '</div>';
    container.appendChild(col);
  });
}

function togglePlace(placeId) {
  var allPlaces = placesData.cultural.concat(placesData.nature);
  var place     = allPlaces.find(function (p) { return p.id === placeId; });
  if (!place) return;

  var idx = selectedPlaces.findIndex(function (p) { return p.id === placeId; });

  if (idx === -1) {
    var days   = loadState('days', 2);
    var totalH = days * 8;
    var usedH  = selectedPlaces.reduce(function (s, p) { return s + p.hours; }, 0);
    if (usedH + place.hours > totalH) {
      var warn = document.getElementById('time-warn');
      if (warn) warn.classList.add('wc-time-danger');
    }
    selectedPlaces.push(place);
  } else {
    selectedPlaces.splice(idx, 1);
    var warn2 = document.getElementById('time-warn');
    if (warn2) warn2.classList.remove('wc-time-danger');
  }

  saveState('places', selectedPlaces);

  var isSel = selectedPlaces.some(function (p) { return p.id === placeId; });
  var card  = document.getElementById('card-' + placeId);
  var btn   = document.getElementById('btn-'  + placeId);
  if (card) card.classList.toggle('selected', isSel);
  if (btn)  {
    btn.classList.toggle('selected-btn', isSel);
    btn.textContent = isSel ? '✓ Selected' : 'Details';
  }

  updateSelectionFooter();
}


function updateSelectionFooter() {
  var days   = loadState('days', 2);
  var totalH = days * 8;
  var usedH  = selectedPlaces.reduce(function (s, p) { return s + p.hours; }, 0);
  var remH   = totalH - usedH;
  var count  = selectedPlaces.length;

  function setText(id, val) {
    var e = document.getElementById(id);
    if (e) e.textContent = val;
  }

  setText('sel-count',   count);
  setText('sel-time',    usedH + 'h');
  setText('tb-selected', count + ' Places');

  var remEl = document.getElementById('sel-rem');
  if (remEl) {
    remEl.textContent = '⏱️ ' + remH.toFixed(1) + 'h remaining';
    remEl.style.color = remH < 0 ? '#e00' : '';
  }
}


function filterPlaces() {
  var q = (document.getElementById('place-search').value || '').toLowerCase();
  document.querySelectorAll('.wc-place-card').forEach(function (card) {
    var name = card.querySelector('.wc-place-name').textContent.toLowerCase();
    var col  = card.closest('[class*="col-"]');
    if (col) col.style.display = name.includes(q) ? '' : 'none';
  });
}

function clearSearch() {
  var el = document.getElementById('place-search');
  if (el) { el.value = ''; filterPlaces(); }
}

function goToItinerary() {
  if (selectedPlaces.length === 0) {
    alert('Please select at least one place to visit!');
    return;
  }
  window.scrollTo({ top: 0, behavior: 'smooth' });
  setTimeout(function () {
    window.location.href = 'itinerary.html';
  }, 200);
}


function buildItinerary() {
  if (!document.getElementById('day1-content')) return;

  var dest      = loadState('destination', 'Kandy');
  var days      = loadState('days', 2);
  var travelers = loadState('travelers', 2);
  var date      = loadState('date', '');
  var places    = loadState('places', []);

  function setText(id, val) {
    var e = document.getElementById(id);
    if (e) e.textContent = val;
  }

  setText('sum-dest',      dest);
  setText('sum-days',      days + ' Days');
  setText('sum-travelers', travelers + ' People');
  setText('sum-places',    places.length + ' Places');
  setText('itin-dest-sub', dest);

  var totalH = places.reduce(function (s, p) { return s + p.hours; }, 0);
  setText('sum-time', totalH + ' Hours');

  // Split into Day 1 / Day 2 (max 8h per day)
  var DAY_LIMIT = 8;
  var day1 = [], day2 = [], d1h = 0;

  places.forEach(function (p) {
    if (d1h + p.hours <= DAY_LIMIT) {
      day1.push(p);
      d1h += p.hours;
    } else {
      day2.push(p);
    }
  });

  // Overflow alert
  var ov = document.getElementById('ov-alert');
  if (ov) {
    if (day2.length > 0) {
      ov.style.display = 'block';
      ov.textContent   = '⚠️ Only ' + day1.length + ' of ' + places.length + ' places fit in Day 1\'s 8 hours. Remaining moved to Day 2 automatically.';
    } else {
      ov.style.display = 'none';
    }
  }

  renderTimeline('day1-content', day1);
  renderTimeline('day2-content', day2.length ? day2 : [{ name: 'Free Day / Rest', hours: 0, icon: '😎', category: 'Rest' }]);
  renderSelectedList(day1, day2);

  // Countdown timer
  if (date) {
    var diff = Math.ceil((new Date(date) - new Date()) / 86400000);
    setText('countdown-num', diff > 0 ? diff : '0');
  } else {
    setText('countdown-num', '--');
  }
}


function renderTimeline(containerId, places) {
  var container = document.getElementById(containerId);
  if (!container) return;
  container.innerHTML = '';

  if (!places.length) {
    container.innerHTML = '<p class="text-muted ps-2">No places for this day.</p>';
    return;
  }

  var h = 8, m = 0, p = 'AM';

  places.forEach(function (place, idx) {
    var timeStr = timeFmt(h, m, p);
    var div     = document.createElement('div');
    div.className = 'wc-tl-item';
    div.innerHTML =
      '<div class="wc-tl-dot ' + (idx === 0 ? 'active-dot' : '') + '"></div>' +
      '<div class="wc-tl-card">' +
        '<div class="wc-tl-time">' + timeStr + '</div>' +
        '<div>' +
          '<div class="wc-tl-place">' + (place.icon || '📍') + ' ' + place.name + '</div>' +
          '<div>' +
            (place.hours > 0 ? '<span class="wc-tl-chip">⏱️ ' + place.hours + ' hrs</span>' : '') +
            '<span class="wc-tl-chip">' + (place.category || 'Activity') + '</span>' +
            (place.hours > 0 ? '<span class="wc-tl-chip">Until ' + timeEnd(h, m, p, place.hours) + '</span>' : '') +
          '</div>' +
        '</div>' +
      '</div>';
    container.appendChild(div);

    var advanced = timeAdvance(h, m, p, place.hours + 0.25);
    h = advanced[0]; m = advanced[1]; p = advanced[2];

    // Lunch break after 2nd place when more remain
    if (idx === 1 && places.length > 2) {
      var lunchDiv = document.createElement('div');
      lunchDiv.className = 'wc-tl-item';
      lunchDiv.innerHTML =
        '<div class="wc-tl-dot"></div>' +
        '<div class="wc-tl-card">' +
          '<div class="wc-tl-time">' + timeFmt(h, m, p) + '</div>' +
          '<div>' +
            '<div class="wc-tl-place">🍽️ Lunch Break</div>' +
            '<div><span class="wc-tl-chip">⏱️ 1 hr</span><span class="wc-tl-chip">Rest</span></div>' +
          '</div>' +
        '</div>';
      container.appendChild(lunchDiv);
      var afterLunch = timeAdvance(h, m, p, 1);
      h = afterLunch[0]; m = afterLunch[1]; p = afterLunch[2];
    }
  });
}


function renderSelectedList(day1, day2) {
  var container = document.getElementById('selected-places-list');
  if (!container) return;
  container.innerHTML = '';

  var all = day1.map(function (pl) { return Object.assign({}, pl, { dl: 'Day 1' }); })
       .concat(day2.map(function (pl) { return Object.assign({}, pl, { dl: 'Day 2' }); }));

  if (!all.length) {
    container.innerHTML = '<p class="text-muted small">No places selected. <a href="destinations.html">Go back</a></p>';
    return;
  }

  all.forEach(function (pl) {
    var row = document.createElement('div');
    row.className = 'wc-sel-place-row';
    row.innerHTML =
      '<span style="font-size:20px">' + (pl.icon || '📍') + '</span>' +
      '<div>' +
        '<div class="wc-sp-name">' + pl.name + '</div>' +
        '<div class="wc-sp-day">' + pl.hours + ' hrs · ' + pl.dl + '</div>' +
      '</div>' +
      '<span style="color:var(--cyan-dk);margin-left:auto">✓</span>';
    container.appendChild(row);
  });
}


function switchDay(day) {
  document.getElementById('day1-timeline').classList.toggle('d-none', day !== 1);
  document.getElementById('day2-timeline').classList.toggle('d-none', day !== 2);
  document.getElementById('day1-tab').classList.toggle('active-day-tab', day === 1);
  document.getElementById('day2-tab').classList.toggle('active-day-tab', day === 2);
}


function renderHotels(filter) {
  filter = filter || 'all';
  var container = document.getElementById('hotel-cards-container');
  if (!container) return;
  container.innerHTML = '';

  var dest    = loadState('destination', 'Kandy');
  var titleEl = document.getElementById('hotel-dest-title');
  if (titleEl) titleEl.textContent = dest;

  var list = filter === 'all' ? hotelsData : hotelsData.filter(function (h) { return h.cat === filter; });

  list.forEach(function (hotel) {
    var col = document.createElement('div');
    col.className = 'col-lg-4 col-md-6';
    col.innerHTML =
      '<div class="wc-hotel-card">' +
        '<div class="wc-hotel-img">' +
          '<img src="' + hotel.img + '" alt="' + hotel.name + '" style="width:100%;height:100%;object-fit:cover;"/>' +
          '<div class="wc-hotel-badge badge-' + hotel.cat + '">' + hotel.cat.toUpperCase() + '</div>' +
        '</div>' +
        '<div class="wc-hotel-body">' +
          '<div class="wc-hotel-name">' + hotel.name + '</div>' +
          '<div class="wc-hotel-loc">📍 ' + hotel.loc + '</div>' +
          '<div class="d-flex flex-wrap gap-1 mb-2">' +
            hotel.amenities.map(function (a) { return '<span class="wc-amen">' + a + '</span>'; }).join('') +
          '</div>' +
          '<div class="wc-rating-row">' +
            '<div class="wc-rating-av">😊</div>' +
            '<div>' +
              '<div class="wc-rating-name">' + hotel.reviewer +
                ' <span class="wc-stars">' + '★'.repeat(hotel.stars) + '☆'.repeat(5 - hotel.stars) + '</span>' +
              '</div>' +
              '<div class="wc-rating-txt">' + hotel.review + '</div>' +
            '</div>' +
          '</div>' +
          '<div class="wc-hotel-footer">' +
            '<div>' +
              '<div class="wc-price">LKR ' + hotel.price + '</div>' +
              '<div class="wc-per">per night</div>' +
            '</div>' +
            '<button class="wc-book-btn" onclick="openBooking(\'' + hotel.name + '\')">Book Now</button>' +
          '</div>' +
        '</div>' +
      '</div>';
    container.appendChild(col);
  });
}

function filterHotels(cat, btn) {
  document.querySelectorAll('.wc-htoggle').forEach(function (b) {
    b.classList.remove('active-htoggle');
  });
  btn.classList.add('active-htoggle');
  renderHotels(cat);
}

var currentHotelName = '';

function openBooking(name) {
  currentHotelName = name;

  var hn = document.getElementById('modal-hotel-name');
  if (hn) hn.textContent = name;

  document.getElementById('modal-form-view').classList.remove('d-none');
  document.getElementById('modal-success-view').classList.add('d-none');

  ['book-name', 'book-email'].forEach(function (id) {
    var el = document.getElementById(id);
    if (el) el.value = '';
  });
  ['err-book-name', 'err-book-email'].forEach(function (id) {
    var el = document.getElementById(id);
    if (el) el.classList.add('d-none');
  });

  var modal = new bootstrap.Modal(document.getElementById('bookingModal'));
  modal.show();
}

function submitBooking() {
  var name     = (document.getElementById('book-name').value  || '').trim();
  var email    = (document.getElementById('book-email').value || '').trim();
  var emailOk  = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);

  document.getElementById('err-book-name').classList.toggle('d-none',  !!name);
  document.getElementById('err-book-email').classList.toggle('d-none', emailOk);

  if (!name || !emailOk) return;

  document.getElementById('modal-form-view').classList.add('d-none');
  document.getElementById('modal-success-view').classList.remove('d-none');
  var sn = document.getElementById('success-hotel-name');
  if (sn) sn.textContent = currentHotelName;
}

function resetModal() {
  document.getElementById('modal-form-view').classList.remove('d-none');
  document.getElementById('modal-success-view').classList.add('d-none');
}


document.addEventListener('DOMContentLoaded', function () {

  // Load saved state
  loadAllState();

  // Set min date on plan page
  var dateEl = document.getElementById('inp-date');
  if (dateEl) dateEl.min = new Date().toISOString().split('T')[0];

  // Restore traveler count display
  var cntEl = document.getElementById('traveler-count');
  if (cntEl) cntEl.textContent = travelerCount;

  // Restore active day pill
  document.querySelectorAll('.wc-pill').forEach(function (pill) {
    var n = parseInt(pill.textContent);
    if (n === selectedDays || (selectedDays >= 5 && pill.textContent.includes('5'))) {
      pill.classList.add('active-pill');
    }
  });

  // Run initial live preview (plan page)
  updatePreview();

  // Animate progress bars (home page)
  animateProgressBars();

  // Auto-start image slider (home page)
  if (document.getElementById('slider-track')) {
    setInterval(nextSlide, 3500);
  }

  // Render place cards (recommendations page)
  renderPlaceCards();

  // Build itinerary (itinerary page)
  buildItinerary();

  // Render hotels (hotels page)
  renderHotels('all');

});

var destinationsData = {
  kandy: {
    name:   'Kandy',
    tag:    '✦ CULTURAL · HERITAGE',
    hero:   'https://images.unsplash.com/photo-1588598198321-9735fd8e6e3b?w=1200&q=80',
    badges: ['8 Places', '2–3 Days', 'Cultural'],
    intro:  'Kandy is the cultural capital of Sri Lanka, nestled in the heart of the hill country. Famous for the sacred Temple of the Tooth Relic, Kandy Lake, and the vibrant Kandy Esala Perahera festival, this city blends natural beauty with rich history.',
    chips:  ['📍 Central Province', '🌡️ 20–28°C', '🗣️ Sinhala / Tamil', '💰 Budget Friendly'],
    places: [
      { name: 'Temple of the Tooth',         time: '2.5 hrs', type: 'Cultural',  img: 'https://www.attractionsinsrilanka.com/wp-content/uploads/2019/07/Sri-Dalada-Maligawa-Temple-of-the-Tooth-Relic.jpg' },
      { name: 'Peradeniya Botanical Garden', time: '3 hrs',   type: 'Nature',    img: 'https://nexttravelsrilanka.com/wp-content/uploads/2021/03/A-path-by-the-landscaped-lawns-with-colourful-fauna-at-the-Peradeniya-Botanical-Garden.jpg' },
      { name: 'Kandy Lake Walk',             time: '1 hr',    type: 'Scenic',    img: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQenT1FvN2Xo5AxU84FuFXPzr9x4zQE8NzPYg&s' },
      { name: 'Bahiravokanda Statue',        time: '1 hr',    type: 'Religious', img: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRRu_kzTon5L8v_V15x6UQz2UnGUoLNlM3oZQ&s' },
      { name: 'Victoria Dam',                time: '2 hrs',   type: 'Scenic',    img: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSyl6OWjwQn5qLG69tMnKzoSBK1ZKjGhKbQiQ&s' },
      { name: 'Kandy City Walk',             time: '1.5 hrs', type: 'Cultural',  img: 'https://media.tacdn.com/media/attractions-splice-spp-674x446/09/29/a9/bc.jpg' },
    ]
  },
  ella: {
    name:   'Ella',
    tag:    '✦ NATURE · ADVENTURE',
    hero:   'https://images.unsplash.com/photo-1586861635167-e5223aadc9fe?w=1200&q=80',
    badges: ['6 Places', '1–2 Days', 'Adventure'],
    intro:  'Ella is a breathtaking town surrounded by misty mountains, cascading waterfalls and lush tea estates. Known for the iconic Nine Arch Bridge and Little Adam\'s Peak, Ella is a paradise for hikers and nature lovers.',
    chips:  ['📍 Badulla District', '🌡️ 15–22°C', '🥾 Hiking Paradise', '📸 Scenic Views'],
    places: [
      { name: 'Nine Arch Bridge',    time: '1.5 hrs', type: 'Scenic',    img: 'https://flyingravana.eme-devops.com/2019/01/nine-arch-2-5.jpg' },
      { name: "Little Adam's Peak",  time: '2 hrs',   type: 'Hiking',    img: 'https://media-cdn.tripadvisor.com/media/attractions-splice-spp-674x446/07/be/67/91.jpg' },
      { name: 'Ella Rock',           time: '4 hrs',   type: 'Adventure', img: 'https://www.srilankainstyle.com/storage/app/media/Experiences/Ella%20Rock%20Climb/Ella-Rock-Climb-slider-5.jpg' },
      { name: 'Ravana Falls',        time: '1 hr',    type: 'Nature',    img: 'https://www.lovesrilanka.org/wp-content/uploads/2020/04/LS_RavanaFalls_Mob_800x1000.jpg' },
      { name: 'Ella Town Walk',      time: '1 hr',    type: 'Cultural',  img: 'https://www.stokedtotravel.com/wp-content/uploads/2019/06/IMG_6453-1000x667.jpg' },
      { name: 'Tea Factory Tour',    time: '2 hrs',   type: 'Cultural',  img: 'https://overatours.com/wp-content/uploads/2021/10/Ella-Tea-Factory.jpg' },
    ]
  },
  sigiriya: {
    name:   'Sigiriya',
    tag:    '✦ HERITAGE · HISTORY',
    hero:   'https://images.unsplash.com/photo-1567254790880-c6293c6b4b6a?w=1200&q=80',
    badges: ['5 Places', '1–2 Days', 'Heritage'],
    intro:  'Sigiriya, the magnificent Lion Rock fortress, is a UNESCO World Heritage Site. This 5th-century rock fortress features stunning frescoes, mirror walls and breathtaking panoramic views from the summit.',
    chips:  ['📍 Matale District', '🌡️ 25–32°C', '🏛️ UNESCO Heritage', '⏱️ Best at Sunrise'],
    places: [
      { name: 'Sigiriya Rock Fortress',  time: '3 hrs',   type: 'Heritage',  img: 'https://cf.bstatic.com/xdata/images/hotel/max1024x768/550721671.jpg?k=785c8febc7874ad23f1aac1b3e4a752976b2ace4b97e66a2f54ed39707989317&o=' },
      { name: 'Pidurangala Rock',        time: '2 hrs',   type: 'Hiking',    img: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSd_4dJU-fIv_Fk6mJwWa_LzSeIXB-M88vhyQ&s' },
      { name: 'Sigiriya Museum',         time: '1 hr',    type: 'Cultural',  img: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQgOyrlwOdFkLEQmjtGgQ6BayS-TIftYtPeMQ&s' },
      { name: 'Dambulla Cave Temple',    time: '2 hrs',   type: 'Religious', img: 'https://www.travelmapsrilanka.com/destinations/destinationimages/dambulla-cave-temple.webp' },
      { name: 'Minneriya National Park', time: '3.5 hrs', type: 'Wildlife',  img: 'https://duqjpivknq39s.cloudfront.net/2019/03/800x750-27.jpg' },
    ]
  }
};



/* Open Destination Modal */
function openDestModal(destKey) {
  var dest = destinationsData[destKey];
  if (!dest) return;

  // Set hero image
  var heroImg = document.getElementById('dest-modal-hero-img');
  if (heroImg) heroImg.src = dest.hero;

  // Set text
  document.getElementById('dest-modal-tag').textContent  = dest.tag;
  document.getElementById('dest-modal-name').textContent = dest.name;
  document.getElementById('dest-modal-intro').textContent = dest.intro;
  document.getElementById('dest-modal-plan-name').textContent = dest.name;

  // Badges
  var badgesEl = document.getElementById('dest-modal-badges');
  badgesEl.innerHTML = dest.badges.map(function (b) {
    return '<span class="wc-mini-badge">' + b + '</span>';
  }).join('');

  // Info chips
  var chipsEl = document.getElementById('dest-modal-chips');
  chipsEl.innerHTML = dest.chips.map(function (c) {
    return '<span class="wc-dest-modal-chip">' + c + '</span>';
  }).join('');

  // Places cards
  var placesEl = document.getElementById('dest-modal-places');
  placesEl.innerHTML = '';
  dest.places.forEach(function (place) {
    var col = document.createElement('div');
    col.className = 'col-6 col-md-4';
    col.innerHTML =
      '<div class="wc-place-mini-card">' +
        '<img src="' + place.img + '" alt="' + place.name + '" class="wc-place-mini-img" onerror="this.style.background=\'#0d2a4a\';this.style.height=\'130px\'"/>' +
        '<div class="wc-place-mini-body">' +
          '<div class="wc-place-mini-name">' + place.name + '</div>' +
          '<div class="wc-place-mini-meta">⏱️ ' + place.time + ' &nbsp;·&nbsp; 🏷️ ' + place.type + '</div>' +
        '</div>' +
      '</div>';
    placesEl.appendChild(col);
  });

  // Show Bootstrap modal
  var modal = new bootstrap.Modal(document.getElementById('destModal'));
  modal.show();
}

/* Close Destination Modal */
function closeDestModal() {
  var modalEl = document.getElementById('destModal');
  var modal   = bootstrap.Modal.getInstance(modalEl);
  if (modal) modal.hide();
}