(() => {
  'use strict';

  // Centralised catalogue: expand Sri Lanka places + foods here.
  window.SL = window.SL || {};

  SL.images = {
    Heritage: "https://images.unsplash.com/photo-1544735716-17f32a0b9f49?auto=format&fit=crop&w=1400&q=80",
    Beach: "https://images.unsplash.com/photo-1500375592092-40eb2168fd21?auto=format&fit=crop&w=1400&q=80",
    HillCountry: "https://images.unsplash.com/photo-1543689870-5f4d2a6a58b5?auto=format&fit=crop&w=1400&q=80",
    Wildlife: "https://images.unsplash.com/photo-1508672019048-805c876b67e2?auto=format&fit=crop&w=1400&q=80",
    City: "https://images.unsplash.com/photo-1526481280695-3c687fd5432c?auto=format&fit=crop&w=1400&q=80",
    Food: "https://images.unsplash.com/photo-1532634896-26909d0d4b1b?auto=format&fit=crop&w=1400&q=80",
    Sweets: "https://images.unsplash.com/photo-1486427944299-d1955d23e34d?auto=format&fit=crop&w=1400&q=80"
  };

  SL.destinations = [
    { id:"sigiriya", name:"Sigiriya Rock Fortress", province:"Central", category:"Heritage",
      tags:["UNESCO","Cultural Triangle"], blurb:"Ancient rock citadel and gardens—perfect as a sunrise climb." },

    { id:"dambulla", name:"Dambulla Cave Temple", province:"Central", category:"Heritage",
      tags:["UNESCO","Temple"], blurb:"Cave shrines with murals and Buddha statues (Cultural Triangle)." },

    { id:"kandy", name:"Sacred City of Kandy", province:"Central", category:"Heritage",
      tags:["UNESCO","Temple of the Tooth"], blurb:"Last royal capital—culture, lake views, and sacred heritage." },

    { id:"anuradhapura", name:"Sacred City of Anuradhapura", province:"North Central", category:"Heritage",
      tags:["UNESCO","Ancient City"], blurb:"Ancient capital with stupas and sacred sites." },

    { id:"polonnaruwa", name:"Ancient City of Polonnaruwa", province:"North Central", category:"Heritage",
      tags:["UNESCO","Ruins"], blurb:"Stone temples and royal ruins—great for cycling days." },

    { id:"gallefort", name:"Galle Fort", province:"Southern", category:"Heritage",
      tags:["UNESCO","Colonial"], blurb:"Walk ramparts at sunset; cafés and boutique streets inside the fort." },

    { id:"mirissa", name:"Mirissa", province:"Southern", category:"Beach",
      tags:["Whale watching","Beach"], blurb:"Relaxing beach town and famous whale‑watching base." },

    { id:"hikkaduwa", name:"Hikkaduwa", province:"Southern", category:"Beach",
      tags:["Coral","Surf"], blurb:"Beach vibes, snorkelling spots, and lively evenings." },

    { id:"trincomalee", name:"Trincomalee", province:"Eastern", category:"Beach",
      tags:["Harbour","Temples","Beaches"], blurb:"East‑coast beaches and a historic port city." },

    { id:"arugambay", name:"Arugam Bay", province:"Eastern", category:"Beach",
      tags:["Surf"], blurb:"Sri Lanka’s surf capital—add a ‘surf days’ block to your itinerary." },

    { id:"nuwaraeliya", name:"Nuwara Eliya", province:"Central", category:"HillCountry",
      tags:["Tea plantations","Cool climate"], blurb:"Tea country atmosphere—parks, lakes, and plantations." },

    { id:"ella", name:"Ella", province:"Uva", category:"HillCountry",
      tags:["Tea","Hikes"], blurb:"Hill town surrounded by tea plantations and viewpoints." },

    { id:"ninearch", name:"Nine Arch Bridge (Ella)", province:"Uva", category:"HillCountry",
      tags:["Photography","Train"], blurb:"Iconic hill‑country bridge—best timed with a passing train." },

    { id:"horton", name:"Horton Plains", province:"Central", category:"Wildlife",
      tags:["Central Highlands","Hike"], blurb:"High plateau hikes and dramatic viewpoints." },

    { id:"sinharaja", name:"Sinharaja Forest Reserve", province:"Sabaragamuwa/Southern", category:"Wildlife",
      tags:["UNESCO","Rainforest"], blurb:"Biodiversity hotspot—guided rainforest walks." },

    { id:"yala", name:"Yala National Park", province:"Southern/Uva", category:"Wildlife",
      tags:["Safari","Leopards"], blurb:"Classic safari destination—plan dawn/dusk game drives." },

    { id:"udawalawe", name:"Udawalawe National Park", province:"Sabaragamuwa/Uva", category:"Wildlife",
      tags:["Elephants","Safari"], blurb:"Elephant‑spotting favourite—easy day trip planning." },

    { id:"colombo", name:"Colombo", province:"Western", category:"City",
      tags:["Markets","Museums","Food"], blurb:"Start/end hub—cafés, shopping, and city experiences." },

    { id:"jaffna", name:"Jaffna", province:"Northern", category:"City",
      tags:["Culture","Food"], blurb:"Distinct northern culture and incredible regional cuisine." }
  ];

  SL.foods = [
    { id:"rice_curry", name:"Rice & Curry", meal:"Lunch/Dinner", region:"All island", imgKey:"Food",
      tags:["Curries","Staple"], blurb:"The classic meal—rice with multiple curries and sambols." },

    { id:"hoppers", name:"Hoppers (Appa)", meal:"Breakfast/Dinner", region:"All island", imgKey:"Food",
      tags:["Coconut","Street food"], blurb:"Bowl‑shaped pancakes, often served with sambol and curry." },

    { id:"string_hoppers", name:"String Hoppers (Indi Appa)", meal:"Breakfast/Dinner", region:"All island", imgKey:"Food",
      tags:["Steamed","Rice flour"], blurb:"Steamed rice‑flour noodles—perfect with coconut sambol." },

    { id:"pittu", name:"Pittu", meal:"Breakfast/Dinner", region:"All island", imgKey:"Food",
      tags:["Coconut","Steamed"], blurb:"Steamed rice flour + coconut—often eaten with curry." },

    { id:"pol_sambol", name:"Pol Sambol", meal:"Any", region:"All island", imgKey:"Food",
      tags:["Coconut","Spicy"], blurb:"Grated coconut relish—fresh, spicy, and addictive." },

    { id:"lunu_miris", name:"Lunu Miris", meal:"Any", region:"All island", imgKey:"Food",
      tags:["Spicy","Onion"], blurb:"Hot onion sambol—common with hoppers and kiribath." },

    { id:"maal_ambul", name:"Maalu Ambulthiyal", meal:"Lunch/Dinner", region:"Southern", imgKey:"Food",
      tags:["Fish","Sour"], blurb:"Southern‑style sour fish curry—powerful flavour." },

    { id:"lamprais", name:"Lamprais", meal:"Lunch", region:"Western", imgKey:"Food",
      tags:["Banana leaf","Dutch influence"], blurb:"Rice and accompaniments baked in plantain leaves." },

    { id:"kottu", name:"Kottu Roti", meal:"Dinner", region:"All island", imgKey:"Food",
      tags:["Street food","Chopped roti"], blurb:"Famous night street food—fast, spicy, filling." },

    { id:"curd_treacle", name:"Buffalo curd & palm honey", meal:"Dessert", region:"Southern/All island", imgKey:"Sweets",
      tags:["Curd","Sweet"], blurb:"A classic dessert: creamy curd with sweet treacle/palm honey." },

    { id:"wattalappam", name:"Wattalapam", meal:"Dessert", region:"All island", imgKey:"Sweets",
      tags:["Coconut","Jaggery"], blurb:"Rich coconut custard dessert—festival favourite." }
  ];
})();
