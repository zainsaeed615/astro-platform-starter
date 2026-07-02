<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class VP_Seeder {
	public static function seed_defaults() {
		$json = <<<'JSON'
[
  {
    "name": "Waterhouse Gardens",
    "slug": "waterhouse-gardens",
    "location": "UK",
    "city": "Manchester",
    "status": "Available",
    "price": "£300,000",
    "bedrooms": "1 - 3",
    "completion": "Completed",
    "yield": "6%",
    "deposit": "25%",
    "tenure": "Leasehold 999 years",
    "summary": "Waterhouse Gardens is a premium residential development in Manchester city centre, offering high-spec 1, 2, and 3-bedroom apartments within a vibrant mixed-use neighbourhood. Positioned in a major regeneration zone, it delivers strong rental demand and long-term capital growth potential.",
    "overview": "Waterhouse Gardens is a landmark Manchester property investment opportunity, delivering 556 high-spec apartments across five architecturally striking towers. Designed as a vibrant mixed-use neighbourhood, the development also includes over 30,000 sq. ft of commercial, retail, and leisure space—creating a dynamic destination for modern city living.\n\nLocated in the heart of Manchester city centre, between key districts such as Greengate, NOMA, and the historic core, the development benefits from excellent connectivity to major employment hubs, universities, and transport links. This prime positioning supports consistent tenant demand from professionals, graduates, and city workers.\n\nAs part of the wider Great Ducie Street regeneration masterplan, Waterhouse Gardens sits within one of Manchester’s most exciting growth areas—making it a strong addition to any property investment portfolio.",
    "photos": [
      "https://www.vidiancapital.com/objects/uploads/a1201e51-a892-4bc9-bb7e-6c0595378a5e.jpg",
      "https://www.vidiancapital.com/objects/uploads/b207c50f-4b2c-48e8-a24a-2a6fa269ee19.jpg",
      "https://www.vidiancapital.com/objects/uploads/07a4aa84-f6d7-4c71-aa5d-91dacefbcc26.jpg",
      "https://www.vidiancapital.com/objects/uploads/7632f790-7c55-4486-9836-101e06b838c1.jpg",
      "https://www.vidiancapital.com/objects/uploads/8a2b705c-b391-4c01-9d35-02685d11baed.jpg",
      "https://www.vidiancapital.com/objects/uploads/96241188-3389-4be4-99c3-4c9887949573.jpg",
      "https://www.vidiancapital.com/objects/uploads/5aa80d34-9f98-4113-a45b-4ba598b45a77.jpg",
      "https://www.vidiancapital.com/objects/uploads/6606b820-ed49-46da-98a8-478e03a74bb7.jpg",
      "https://www.vidiancapital.com/objects/uploads/d2c80db7-8897-460b-bc48-a9e6d2a703e4.jpg",
      "https://www.vidiancapital.com/objects/uploads/acf7abc0-5787-426e-9787-087a57cde7c3.jpg",
      "https://www.vidiancapital.com/objects/uploads/7d5f88ba-9666-43ad-aa2a-565bf6a1578a.jpg",
      "https://www.vidiancapital.com/objects/uploads/0a4ad016-6d8d-46e6-8367-6ef20552a23d.jpg",
      "https://www.vidiancapital.com/objects/uploads/1dea09c6-863c-47a1-8ea1-8bce9fb9ebbf.jpg",
      "https://www.vidiancapital.com/objects/uploads/567d323c-82e9-4fd5-8288-ee3e91755170.jpg",
      "https://www.vidiancapital.com/objects/uploads/3298690e-b19d-4114-a29a-a27567e23a05.jpg"
    ],
    "stats": [
      {
        "icon": "dashicons-money-alt",
        "label": "Prices From",
        "value": "£300,000"
      },
      {
        "icon": "dashicons-chart-bar",
        "label": "Expected Yields",
        "value": "6%"
      },
      {
        "icon": "dashicons-calendar-alt",
        "label": "Completion",
        "value": "Completed"
      },
      {
        "icon": "dashicons-admin-home",
        "label": "Bedrooms",
        "value": "1 - 3"
      },
      {
        "icon": "dashicons-vault",
        "label": "Deposit",
        "value": "25%"
      },
      {
        "icon": "dashicons-media-document",
        "label": "Tenure",
        "value": "Leasehold 999 years"
      }
    ],
    "why": [
      {
        "icon": "dashicons-star-filled",
        "text": "Prime City Centre Location"
      },
      {
        "icon": "dashicons-star-filled",
        "text": "Situated within walking distance of Manchester’s key business districts, ensuring strong tenant demand."
      },
      {
        "icon": "dashicons-star-filled",
        "text": "Strong Capital Growth Potential"
      },
      {
        "icon": "dashicons-star-filled",
        "text": "Located in a major regeneration zone driving long-term value appreciation."
      },
      {
        "icon": "dashicons-star-filled",
        "text": "Reliable Rental Income"
      },
      {
        "icon": "dashicons-star-filled",
        "text": "Expected yields of 6–6.5%, supported by one of the UK’s strongest rental markets."
      },
      {
        "icon": "dashicons-star-filled",
        "text": "Lifestyle-Led Development"
      },
      {
        "icon": "dashicons-star-filled",
        "text": "Premium amenities and high-quality design maximise tenant appeal and retention."
      }
    ],
    "highlights": [
      {
        "icon": "dashicons-marker",
        "text": "556 high-spec apartments, duplexes, and penthouses"
      },
      {
        "icon": "dashicons-marker",
        "text": "Five architecturally striking residential towers"
      },
      {
        "icon": "dashicons-marker",
        "text": "30,000 sq. ft of commercial, retail, and leisure space"
      },
      {
        "icon": "dashicons-marker",
        "text": "Completed development ready for occupancy"
      },
      {
        "icon": "dashicons-marker",
        "text": "Located within the Great Ducie Street regeneration zone"
      },
      {
        "icon": "dashicons-marker",
        "text": "Developed by leading UK developer Salboy"
      }
    ],
    "amenities": [
      {
        "icon": "dashicons-yes",
        "text": "Wellness & Leisure: Swimming pool, spa, sauna, and steam room"
      },
      {
        "icon": "dashicons-yes",
        "text": "Wellness & Leisure: Fully equipped gym and fitness studio"
      },
      {
        "icon": "dashicons-yes",
        "text": "Lifestyle & Social: Residents’ lounge and entertainment spaces"
      },
      {
        "icon": "dashicons-yes",
        "text": "Lifestyle & Social: Private dining areas and cinema room"
      },
      {
        "icon": "dashicons-yes",
        "text": "Work & Convenience: Co-working spaces and meeting rooms"
      },
      {
        "icon": "dashicons-yes",
        "text": "Work & Convenience: 24/7 concierge service"
      },
      {
        "icon": "dashicons-yes",
        "text": "Work & Convenience: Landscaped podium gardens"
      }
    ],
    "location_highlights": [
      {
        "icon": "dashicons-location",
        "text": "Prime central Manchester location near Greengate, NOMA, and Spinningfields"
      },
      {
        "icon": "dashicons-location",
        "text": "Walking distance to major business districts and employment hubs"
      },
      {
        "icon": "dashicons-location",
        "text": "Close to Victoria Station and key transport links"
      },
      {
        "icon": "dashicons-location",
        "text": "Surrounded by restaurants, retail, and cultural attractions"
      },
      {
        "icon": "dashicons-location",
        "text": "Near leading universities, driving strong rental demand"
      },
      {
        "icon": "dashicons-location",
        "text": "Located within a major regeneration area supporting long-term growth"
      }
    ]
  },
  {
    "name": "Edition Birmingham",
    "slug": "edition-birmingham",
    "location": "UK",
    "city": "Birmingham",
    "status": "Available",
    "price": "£296,958",
    "bedrooms": "1 - 3",
    "completion": "Q3 2028",
    "yield": "6%",
    "deposit": "25%",
    "tenure": "Leasehold 250 Years",
    "summary": "Edition is a landmark luxury development in Birmingham city centre, offering high-spec apartments with five-star amenities. Positioned in a prime location near Centenary Square, it delivers strong rental demand and long-term capital growth in one of the UK’s fastest-growing property markets.",
    "overview": "Edition is a flagship Birmingham property investment opportunity, delivering over 580 luxury apartments across two architecturally striking buildings, including a 45-storey tower. Designed to a five-star standard, the development combines modern design with a hotel-style living experience.\n\nLocated just off Centenary Square, Birmingham’s cultural and business hub, Edition places residents within walking distance of major employers, retail districts, and transport links. With the £700 million Paradise regeneration scheme nearby and the future HS2 rail link set to transform connectivity, the development is ideally positioned for long-term growth.\n\nWith strong tenant demand and a growing population, Edition offers investors a balanced opportunity for both rental income and capital appreciation in the UK’s second city.",
    "photos": [
      "https://www.vidiancapital.com/objects/uploads/6837693f-8e18-4184-8f6f-87804ba6309b.png",
      "https://www.vidiancapital.com/objects/uploads/20e1e4d2-8571-49ef-a94b-5a33cbecfbc4.png",
      "https://www.vidiancapital.com/objects/uploads/c5acde5f-3eb6-4bdb-a1e1-2e918bb354c6.png",
      "https://www.vidiancapital.com/objects/uploads/f47b9361-2bc1-4f6e-82b0-8f9bbb46dbaf.png",
      "https://www.vidiancapital.com/objects/uploads/d311965c-c7df-402b-b20c-80bab9d04af2.png",
      "https://www.vidiancapital.com/objects/uploads/954bfa50-b98b-402d-b012-25cf694ad06c.png",
      "https://www.vidiancapital.com/objects/uploads/ed092d46-2397-4159-af81-5ba63b29f672.png",
      "https://www.vidiancapital.com/objects/uploads/3b2016d2-63b6-49cd-98b9-a787702fbf4c.png",
      "https://www.vidiancapital.com/objects/uploads/55a2cb7c-c0f6-4ac6-bde9-aa58005adeaf.png",
      "https://www.vidiancapital.com/objects/uploads/2c071b25-eabe-4c88-b46c-cc48d120fc0f.png",
      "https://www.vidiancapital.com/objects/uploads/59a3544b-f9f9-4efc-85b2-877d077a359b.png",
      "https://www.vidiancapital.com/objects/uploads/28b26fd6-e8ec-452a-b1bd-6c07594e7b78.png"
    ],
    "stats": [
      {
        "icon": "dashicons-money-alt",
        "label": "Prices From",
        "value": "£296,958"
      },
      {
        "icon": "dashicons-chart-bar",
        "label": "Expected Yields",
        "value": "6%"
      },
      {
        "icon": "dashicons-calendar-alt",
        "label": "Completion",
        "value": "Q3 2028"
      },
      {
        "icon": "dashicons-admin-home",
        "label": "Bedrooms",
        "value": "1 - 3"
      },
      {
        "icon": "dashicons-vault",
        "label": "Deposit",
        "value": "25%"
      },
      {
        "icon": "dashicons-media-document",
        "label": "Tenure",
        "value": "Leasehold 250 Years"
      }
    ],
    "why": [
      {
        "icon": "dashicons-star-filled",
        "text": "Prime City Centre Location"
      },
      {
        "icon": "dashicons-star-filled",
        "text": "Situated in the heart of Birmingham, close to key business and cultural districts."
      },
      {
        "icon": "dashicons-star-filled",
        "text": "High-Growth Market"
      },
      {
        "icon": "dashicons-star-filled",
        "text": "Birmingham is forecast to be one of the top-performing UK cities for house price growth."
      },
      {
        "icon": "dashicons-star-filled",
        "text": "Stable Rental Returns"
      },
      {
        "icon": "dashicons-star-filled",
        "text": "Projected yields of around 6%, supported by strong tenant demand."
      },
      {
        "icon": "dashicons-star-filled",
        "text": "Premium Development Quality"
      },
      {
        "icon": "dashicons-star-filled",
        "text": "Five-star amenities and luxury finishes designed to maximise tenant appeal."
      }
    ],
    "highlights": [
      {
        "icon": "dashicons-marker",
        "text": "Over 580 luxury apartments across two buildings"
      },
      {
        "icon": "dashicons-marker",
        "text": "Landmark 45-storey tower in Birmingham skyline"
      },
      {
        "icon": "dashicons-marker",
        "text": "Prime location near Centenary Square"
      },
      {
        "icon": "dashicons-marker",
        "text": "14,000 sq. ft of premium amenity space"
      },
      {
        "icon": "dashicons-marker",
        "text": "Strong rental demand from professionals and graduates"
      },
      {
        "icon": "dashicons-marker",
        "text": "Developed by leading developer Sphere Group"
      }
    ],
    "amenities": [
      {
        "icon": "dashicons-yes",
        "text": "Wellness & Leisure: 20-metre swimming pool"
      },
      {
        "icon": "dashicons-yes",
        "text": "Wellness & Leisure: Spa with sauna, steam room and hydrapool"
      },
      {
        "icon": "dashicons-yes",
        "text": "Wellness & Leisure: Rooftop gym with skyline views"
      },
      {
        "icon": "dashicons-yes",
        "text": "Lifestyle & Social: Sky lounge and private dining areas"
      },
      {
        "icon": "dashicons-yes",
        "text": "Lifestyle & Social: Cinema terrace and landscaped gardens"
      },
      {
        "icon": "dashicons-yes",
        "text": "Lifestyle & Social: Resident lounges and social spaces"
      },
      {
        "icon": "dashicons-yes",
        "text": "Work & Convenience: Co-working spaces and business lounge"
      },
      {
        "icon": "dashicons-yes",
        "text": "Work & Convenience: 24/7 concierge and security"
      }
    ],
    "location_highlights": [
      {
        "icon": "dashicons-location",
        "text": "3 minutes to Centenary Square"
      },
      {
        "icon": "dashicons-location",
        "text": "12 minutes to Birmingham New Street Station"
      },
      {
        "icon": "dashicons-location",
        "text": "Walking distance to Colmore Business District"
      },
      {
        "icon": "dashicons-location",
        "text": "Close to Michelin-star restaurants and cultural venues"
      },
      {
        "icon": "dashicons-location",
        "text": "Adjacent to £700M Paradise regeneration scheme"
      }
    ]
  },
  {
    "name": "Obsidian",
    "slug": "obsidian",
    "location": "UK",
    "city": "Manchester",
    "status": "Available",
    "price": "£249,000",
    "bedrooms": "1 - 3",
    "completion": "Q4 2026",
    "yield": "6%",
    "deposit": "25%",
    "tenure": "Leasehold 999 years",
    "summary": "Obsidian is a modern high-rise residential development in Manchester city centre, offering stylish apartments with premium amenities. Designed for urban living, it delivers strong rental demand and long-term capital growth in one of the UK’s fastest-growing property markets.",
    "overview": "Obsidian is a landmark Manchester property investment opportunity, comprising a 26-storey tower delivering 250 high-quality apartments in the heart of the city. Designed to combine modern architecture with the industrial heritage of the area, the development creates a bold addition to Manchester’s skyline.\n\nLocated at the intersection of Blackfriars Road, Chapel Street, and Trinity Way, Obsidian sits adjacent to the highly desirable Greengate district, placing residents within walking distance of Manchester city centre and Spinningfields.\n\nWith a mix of studio to three-bedroom apartments, alongside best-in-class amenities and strong connectivity, Obsidian is designed to meet the needs of modern city living—making it highly attractive to both tenants and investors.",
    "photos": [
      "https://www.vidiancapital.com/objects/uploads/a9b8ae46-1585-4b06-8e0d-ecd162eb49db.jpg",
      "https://www.vidiancapital.com/objects/uploads/d5b31003-77ca-4224-a555-8a9576b8afb1.jpg",
      "https://www.vidiancapital.com/objects/uploads/fbec2483-a6bd-4798-a395-57304c156500.jpg",
      "https://www.vidiancapital.com/objects/uploads/3184ebe7-72f4-4804-9e03-ae5cf26c00e6.jpg",
      "https://www.vidiancapital.com/objects/uploads/8c960e72-fca9-4941-96c9-97a405ab7652.jpg",
      "https://www.vidiancapital.com/objects/uploads/de40d867-a423-46c9-9493-78b99eda0392.jpg",
      "https://www.vidiancapital.com/objects/uploads/d6e6b06d-94ec-44e0-ad4a-4c8845d5016b.jpg",
      "https://www.vidiancapital.com/objects/uploads/0751fcb0-e511-4267-b54f-ea2082c697bf.jpg",
      "https://www.vidiancapital.com/objects/uploads/c1da2483-5c50-403e-a0ea-e81277bae235.jpg",
      "https://www.vidiancapital.com/objects/uploads/cfd60d52-6327-47ad-bc1c-82280b6880dd.jpg",
      "https://www.vidiancapital.com/objects/uploads/cbc1a3ba-acc3-43e5-b745-9a289caedc14.jpg",
      "https://www.vidiancapital.com/objects/uploads/d1f76a41-40a4-40fe-a882-fddc798b968b.jpg"
    ],
    "stats": [
      {
        "icon": "dashicons-money-alt",
        "label": "Prices From",
        "value": "£249,000"
      },
      {
        "icon": "dashicons-chart-bar",
        "label": "Expected Yields",
        "value": "6%"
      },
      {
        "icon": "dashicons-calendar-alt",
        "label": "Completion",
        "value": "Q4 2026"
      },
      {
        "icon": "dashicons-admin-home",
        "label": "Bedrooms",
        "value": "1 - 3"
      },
      {
        "icon": "dashicons-vault",
        "label": "Deposit",
        "value": "25%"
      },
      {
        "icon": "dashicons-media-document",
        "label": "Tenure",
        "value": "Leasehold 999 years"
      }
    ],
    "why": [
      {
        "icon": "dashicons-star-filled",
        "text": "Prime City Centre Location"
      },
      {
        "icon": "dashicons-star-filled",
        "text": "Situated between Salford and Manchester city centre, within walking distance of Spinningfields and major employment hubs."
      },
      {
        "icon": "dashicons-star-filled",
        "text": "Strong Capital Growth Potential"
      },
      {
        "icon": "dashicons-star-filled",
        "text": "Manchester continues to outperform many UK regions, driven by population growth, regeneration, and investment."
      },
      {
        "icon": "dashicons-star-filled",
        "text": "High Rental Demand"
      },
      {
        "icon": "dashicons-star-filled",
        "text": "Appeals to professionals, graduates, and city workers seeking modern, well-located apartments."
      },
      {
        "icon": "dashicons-star-filled",
        "text": "Lifestyle-Led Development"
      },
      {
        "icon": "dashicons-star-filled",
        "text": "Premium amenities and high-spec design enhance tenant appeal and long-term rental performance."
      }
    ],
    "highlights": [
      {
        "icon": "dashicons-marker",
        "text": "26-storey landmark residential tower"
      },
      {
        "icon": "dashicons-marker",
        "text": "250 high-spec apartments"
      },
      {
        "icon": "dashicons-marker",
        "text": "Mix of 1, 2 & 3-bedroom units"
      },
      {
        "icon": "dashicons-marker",
        "text": "Located in the popular regeneration area"
      },
      {
        "icon": "dashicons-marker",
        "text": "Contemporary design inspired by industrial heritage"
      },
      {
        "icon": "dashicons-marker",
        "text": "Developed by award-winning UK developer Salboy"
      }
    ],
    "amenities": [
      {
        "icon": "dashicons-yes",
        "text": "Wellness & Leisure: Fully equipped modern gym"
      },
      {
        "icon": "dashicons-yes",
        "text": "Wellness & Leisure: Cinema room with surround sound experience"
      },
      {
        "icon": "dashicons-yes",
        "text": "Lifestyle & Social: Private dining and entertainment spaces"
      },
      {
        "icon": "dashicons-yes",
        "text": "Lifestyle & Social: Resident lounges and community areas"
      },
      {
        "icon": "dashicons-yes",
        "text": "Work & Convenience: Co-working and flexible workspace"
      },
      {
        "icon": "dashicons-yes",
        "text": "Work & Convenience: 24/7 concierge service"
      },
      {
        "icon": "dashicons-yes",
        "text": "Work & Convenience: Secure parcel storage and cycle storage"
      }
    ],
    "location_highlights": [
      {
        "icon": "dashicons-location",
        "text": "Positioned in central Manchester"
      },
      {
        "icon": "dashicons-location",
        "text": "Walking distance to Spinningfields, NOMA, and key business districts"
      },
      {
        "icon": "dashicons-location",
        "text": "Excellent transport links including Salford Central, Victoria Station, and Metrolink"
      },
      {
        "icon": "dashicons-location",
        "text": "Close to leading universities, attracting strong graduate tenant demand"
      },
      {
        "icon": "dashicons-location",
        "text": "Surrounded by restaurants, retail, and cultural hotspots"
      },
      {
        "icon": "dashicons-location",
        "text": "Located within a rapidly growing regeneration area, supporting long-term value growth"
      }
    ]
  },
  {
    "name": "Westminster Point",
    "slug": "westminster-point",
    "location": "UK",
    "city": "Liverpool",
    "status": "Available",
    "price": "£186,000",
    "bedrooms": "Studio - 2",
    "completion": "Q2 2027",
    "yield": "7-10%",
    "deposit": "10%",
    "tenure": "Leasehold 999 years",
    "summary": "Westminster Point is a high-yield residential development in Liverpool city centre, offering modern apartments with short-term let approval. Designed for strong rental income, this development is ideal for investors seeking flexible strategies and above-average returns in a fast-growing UK market.",
    "overview": "Westminster Point is a modern Liverpool property investment opportunity comprising 200 high-spec apartments designed to meet strong demand from both short-term visitors and long-term tenants.\n\nLocated at the gateway to Liverpool city centre, the development benefits from proximity to key transport links, retail hubs, and major tourist destinations such as Liverpool ONE and the Royal Albert Dock. This prime positioning makes it highly attractive for short-term lets, allowing investors to maximise rental income.\n\nWith Liverpool undergoing over £14 billion in regeneration and continued growth in tourism, Westminster Point offers investors the opportunity to capitalise on both high yields and long-term capital appreciation.",
    "photos": [
      "https://www.vidiancapital.com/objects/uploads/fefcb632-9b93-441d-b3e4-fb9cd55fba18.jpg",
      "https://www.vidiancapital.com/objects/uploads/cc1c2880-2f13-4996-9097-83b44ae5f376.jpg",
      "https://www.vidiancapital.com/objects/uploads/28161ef9-1045-4683-895a-14f7e11bbd6a.jpg",
      "https://www.vidiancapital.com/objects/uploads/b05cbc2a-3a5f-421f-ba3b-b1a4e823fcdb.jpg",
      "https://www.vidiancapital.com/objects/uploads/4f752efd-12bf-46a9-9845-8cc2412f9417.png",
      "https://www.vidiancapital.com/objects/uploads/675465b6-499e-4c7a-8d9a-430edbcb08ec.jpg",
      "https://www.vidiancapital.com/objects/uploads/725becde-e2d1-48c6-9345-fbffaf27f408.jpg",
      "https://www.vidiancapital.com/objects/uploads/247b0cd2-019e-46cc-8111-62094059b8f3.jpg"
    ],
    "stats": [
      {
        "icon": "dashicons-money-alt",
        "label": "Prices From",
        "value": "£186,000"
      },
      {
        "icon": "dashicons-chart-bar",
        "label": "Expected Yields",
        "value": "7-10%"
      },
      {
        "icon": "dashicons-calendar-alt",
        "label": "Completion",
        "value": "Q2 2027"
      },
      {
        "icon": "dashicons-admin-home",
        "label": "Bedrooms",
        "value": "Studio - 2"
      },
      {
        "icon": "dashicons-vault",
        "label": "Deposit",
        "value": "10%"
      },
      {
        "icon": "dashicons-media-document",
        "label": "Tenure",
        "value": "Leasehold 999 years"
      }
    ],
    "why": [
      {
        "icon": "dashicons-star-filled",
        "text": "Prime City Centre Location"
      },
      {
        "icon": "dashicons-star-filled",
        "text": "Positioned at the gateway to Liverpool city centre, within easy reach of major attractions and transport hubs."
      },
      {
        "icon": "dashicons-star-filled",
        "text": "Strong Growth Market"
      },
      {
        "icon": "dashicons-star-filled",
        "text": "Liverpool is undergoing large-scale regeneration, driving property values and rental demand."
      },
      {
        "icon": "dashicons-star-filled",
        "text": "High-Yield Investment Strategy"
      },
      {
        "icon": "dashicons-star-filled",
        "text": "Short-term let approval allows investors to achieve higher returns compared to traditional buy-to-let."
      },
      {
        "icon": "dashicons-star-filled",
        "text": "Flexible Rental Demand"
      },
      {
        "icon": "dashicons-star-filled",
        "text": "Appeals to tourists, business travellers, students, and young professionals."
      }
    ],
    "highlights": [
      {
        "icon": "dashicons-marker",
        "text": "200 contemporary apartments"
      },
      {
        "icon": "dashicons-marker",
        "text": "Short-term let approved"
      },
      {
        "icon": "dashicons-marker",
        "text": "Projected 7-10% net rental returns"
      },
      {
        "icon": "dashicons-marker",
        "text": "Prime Liverpool city centre location"
      },
      {
        "icon": "dashicons-marker",
        "text": "Strong tourism and rental demand"
      },
      {
        "icon": "dashicons-marker",
        "text": "Accessible entry price point"
      }
    ],
    "amenities": [
      {
        "icon": "dashicons-yes",
        "text": "Wellness & Leisure: Fully equipped gym"
      },
      {
        "icon": "dashicons-yes",
        "text": "Wellness & Leisure: Wellness facilities with hot and cold experience"
      },
      {
        "icon": "dashicons-yes",
        "text": "Lifestyle & Social: Modern communal areas"
      },
      {
        "icon": "dashicons-yes",
        "text": "Lifestyle & Social: High-spec contemporary interiors"
      },
      {
        "icon": "dashicons-yes",
        "text": "Work & Convenience: Secure entry systems"
      },
      {
        "icon": "dashicons-yes",
        "text": "Work & Convenience: Concierge services"
      }
    ],
    "location_highlights": [
      {
        "icon": "dashicons-location",
        "text": "13 minutes to Liverpool Lime Street Station"
      },
      {
        "icon": "dashicons-location",
        "text": "14 minutes to Liverpool ONE shopping district"
      },
      {
        "icon": "dashicons-location",
        "text": "19 minutes to Royal Albert Dock"
      },
      {
        "icon": "dashicons-location",
        "text": "Close to Liverpool Waters regeneration project"
      },
      {
        "icon": "dashicons-location",
        "text": "Easy access to universities and business districts"
      }
    ]
  },
  {
    "name": "Mercesdes-Benz Places - Binghatti City",
    "slug": "mercesdes-benz-places-binghatti-city",
    "location": "Dubai",
    "city": "Meydan Area - Nad Al Sheba District",
    "status": "Available",
    "price": "£272,344",
    "bedrooms": "Studio - 5",
    "completion": "Q4 2027",
    "yield": "8-10%",
    "deposit": "20%",
    "tenure": "Freehold",
    "summary": "Mercedes-Benz Places | Binghatti City is the world’s first Mercedes-Benz branded residential city, delivering a large-scale masterplanned development in Dubai. Combining iconic design, luxury living, and global brand prestige, it offers investors a rare opportunity to secure property in a landmark, city-scale project.",
    "overview": "Mercedes-Benz Places | Binghatti City is a groundbreaking Dubai property investment opportunity, redefining the concept of urban living through a fully masterplanned branded city. Rather than a single tower, the development consists of a large-scale residential community integrating multiple towers, retail, and lifestyle experiences.\n\nThe project is designed as a city-scale vision, blending Mercedes-Benz’s iconic automotive design philosophy with cutting-edge architecture and urban planning. Every element reflects precision, innovation, and luxury—creating a unique living environment that stands apart from traditional developments.\n\nComprising 12 architecturally striking towers, the development creates a powerful skyline presence, with flowing forms inspired by automotive engineering and performance design.\n\nLocated in Nad Al Sheba, one of Dubai’s emerging and affluent districts, the project offers excellent connectivity to key destinations including Downtown Dubai, Dubai Mall, and major transport routes—ensuring strong long-term demand from residents and investors alike.",
    "photos": [
      "https://www.vidiancapital.com/objects/uploads/0306d6a1-eb95-4a68-88de-25c2b778924a.png",
      "https://www.vidiancapital.com/objects/uploads/698801cb-9969-4ece-b0e5-a212fa8709e4.png",
      "https://www.vidiancapital.com/objects/uploads/c388c7f6-6ef6-4bb7-9b93-49c5915886e4.png",
      "https://www.vidiancapital.com/objects/uploads/93d5bc98-3110-4613-8a36-256607e99985.png",
      "https://www.vidiancapital.com/objects/uploads/cda4d6fc-e22a-42e4-a05b-c34bfdf3578d.png",
      "https://www.vidiancapital.com/objects/uploads/35d56d84-9712-4189-bded-c37c787f4c1d.png",
      "https://www.vidiancapital.com/objects/uploads/6415c3fe-c0dc-4c6f-820b-b57b130f6887.png",
      "https://www.vidiancapital.com/objects/uploads/32d86dcd-aae4-49fc-8e57-02f693eb2fbd.png",
      "https://www.vidiancapital.com/objects/uploads/1b6a7226-ae71-4c2c-ab72-d110b35e3e61.png",
      "https://www.vidiancapital.com/objects/uploads/fdcafe73-c92e-4b97-be58-c1388b23bf72.png",
      "https://www.vidiancapital.com/objects/uploads/6dbf1659-fc66-40e8-a607-b89850fb52b7.png"
    ],
    "stats": [
      {
        "icon": "dashicons-money-alt",
        "label": "Prices From",
        "value": "£272,344"
      },
      {
        "icon": "dashicons-chart-bar",
        "label": "Expected Yields",
        "value": "8-10%"
      },
      {
        "icon": "dashicons-calendar-alt",
        "label": "Completion",
        "value": "Q4 2027"
      },
      {
        "icon": "dashicons-admin-home",
        "label": "Bedrooms",
        "value": "Studio - 5"
      },
      {
        "icon": "dashicons-vault",
        "label": "Deposit",
        "value": "20%"
      },
      {
        "icon": "dashicons-media-document",
        "label": "Tenure",
        "value": "Freehold"
      }
    ],
    "why": [
      {
        "icon": "dashicons-star-filled",
        "text": "Prime Dubai Location – Nad Al Sheba"
      },
      {
        "icon": "dashicons-star-filled",
        "text": "Positioned in a high-growth district with close access to Downtown Dubai, DIFC, and major road networks."
      },
      {
        "icon": "dashicons-star-filled",
        "text": "Strong Capital Growth Potential"
      },
      {
        "icon": "dashicons-star-filled",
        "text": "Dubai continues to attract global investors, with branded residences outperforming standard developments in value growth."
      },
      {
        "icon": "dashicons-star-filled",
        "text": "High Rental Demand"
      },
      {
        "icon": "dashicons-star-filled",
        "text": "Dubai’s tax-free environment and global appeal drive strong demand from professionals, tourists, and high-net-worth tenants."
      },
      {
        "icon": "dashicons-star-filled",
        "text": "World-First Branded City Concept"
      },
      {
        "icon": "dashicons-star-filled",
        "text": "The first Mercedes-Benz branded city, combining brand prestige with large-scale urban development—enhancing long-term desirability and resale value."
      }
    ],
    "highlights": [
      {
        "icon": "dashicons-marker",
        "text": "World’s first Mercedes-Benz branded city"
      },
      {
        "icon": "dashicons-marker",
        "text": "Large-scale masterplanned community"
      },
      {
        "icon": "dashicons-marker",
        "text": "Comprising 12 residential towers"
      },
      {
        "icon": "dashicons-marker",
        "text": "Thousands of residential units across multiple phases"
      },
      {
        "icon": "dashicons-marker",
        "text": "Mix of studios to 5-bedroom luxury residences"
      },
      {
        "icon": "dashicons-marker",
        "text": "Integrated retail, lifestyle, and leisure spaces"
      },
      {
        "icon": "dashicons-marker",
        "text": "Developed by leading UAE developer Binghatti"
      }
    ],
    "amenities": [
      {
        "icon": "dashicons-yes",
        "text": "Wellness & Leisure: Swimming pools and resort-style facilities"
      },
      {
        "icon": "dashicons-yes",
        "text": "Wellness & Leisure: State-of-the-art gyms and fitness centres"
      },
      {
        "icon": "dashicons-yes",
        "text": "Wellness & Leisure: Spa and wellness experiences"
      },
      {
        "icon": "dashicons-yes",
        "text": "Lifestyle & Social: Grand promenade with retail, cafés, and dining"
      },
      {
        "icon": "dashicons-yes",
        "text": "Lifestyle & Social: Landscaped parks with 12 curated lifestyle experiences"
      },
      {
        "icon": "dashicons-yes",
        "text": "Lifestyle & Social: Social and entertainment zones integrated throughout the development"
      },
      {
        "icon": "dashicons-yes",
        "text": "Work & Convenience: Concierge and hospitality-style services"
      },
      {
        "icon": "dashicons-yes",
        "text": "Work & Convenience: Smart home systems"
      },
      {
        "icon": "dashicons-yes",
        "text": "Work & Convenience: Secure parking and 24/7 security"
      }
    ],
    "location_highlights": [
      {
        "icon": "dashicons-location",
        "text": "Close to Downtown Dubai & Burj Khalifa"
      },
      {
        "icon": "dashicons-location",
        "text": "Near Dubai Mall and DIFC"
      },
      {
        "icon": "dashicons-location",
        "text": "Easy access to Sheikh Zayed Road & Al Khail Road"
      },
      {
        "icon": "dashicons-location",
        "text": "Located in Nad Al Sheba, near Meydan Racecourse"
      },
      {
        "icon": "dashicons-location",
        "text": "Short drive to Dubai International Airport"
      }
    ]
  },
  {
    "name": "Canal Heights 2 - Damac",
    "slug": "canal-heights-2",
    "location": "Dubai",
    "city": "Business Bay",
    "status": "Available",
    "price": "£219,921",
    "bedrooms": "1 - 3",
    "completion": "Q3 2027",
    "yield": "7-9%",
    "deposit": "20%",
    "tenure": "Freehold",
    "summary": "Canal Heights 2 is a luxury waterfront development in Business Bay, Dubai, offering branded residences inspired by the elegance of de GRISOGONO. Positioned along the Dubai Canal, it combines premium lifestyle living with strong rental demand and capital growth potential in one of Dubai’s most sought-after locations.",
    "overview": "Canal Heights 2 is an iconic Dubai property investment opportunity developed by DAMAC in collaboration with luxury jewellery brand de GRISOGONO. Inspired by the beauty of the blue topaz gemstone, the development blends high-end design with waterfront living to create a truly distinctive residential experience.\n\nLocated in Business Bay, Dubai’s financial district, the development sits directly along the Dubai Canal, surrounded by premium high-rise towers, hotels, and lifestyle destinations. This prime positioning ensures strong demand from both residents and short-term tenants.\n\nAs a continuation of the success of Canal Heights, this second phase elevates luxury living with enhanced design, curated amenities, and branded interiors—making it a standout option for investors seeking both prestige and performance.",
    "photos": [
      "https://www.vidiancapital.com/objects/uploads/5b1bc36e-1420-4be3-9d80-b92ea46ad737.png",
      "https://www.vidiancapital.com/objects/uploads/3cef7fad-a2b5-4f07-879c-5dd50e729ef2.png",
      "https://www.vidiancapital.com/objects/uploads/d750af9b-c723-4a7f-a37d-38df0a174987.png",
      "https://www.vidiancapital.com/objects/uploads/298a37bf-e01c-4a64-9346-a83806077fa1.png",
      "https://www.vidiancapital.com/objects/uploads/406b26e6-4936-4e59-bc3d-9cf50d489218.png",
      "https://www.vidiancapital.com/objects/uploads/cd7f72e7-8d4f-4f37-ac19-6ce81943072d.png",
      "https://www.vidiancapital.com/objects/uploads/eeb574a9-589b-4fe5-9e6f-5a42024f7530.png",
      "https://www.vidiancapital.com/objects/uploads/eedf3fdd-c1de-447b-9d6c-7708611b1d81.png"
    ],
    "stats": [
      {
        "icon": "dashicons-money-alt",
        "label": "Prices From",
        "value": "£219,921"
      },
      {
        "icon": "dashicons-chart-bar",
        "label": "Expected Yields",
        "value": "7-9%"
      },
      {
        "icon": "dashicons-calendar-alt",
        "label": "Completion",
        "value": "Q3 2027"
      },
      {
        "icon": "dashicons-admin-home",
        "label": "Bedrooms",
        "value": "1 - 3"
      },
      {
        "icon": "dashicons-vault",
        "label": "Deposit",
        "value": "20%"
      },
      {
        "icon": "dashicons-media-document",
        "label": "Tenure",
        "value": "Freehold"
      }
    ],
    "why": [
      {
        "icon": "dashicons-star-filled",
        "text": "Prime Business Bay Waterfront Location"
      },
      {
        "icon": "dashicons-star-filled",
        "text": "Situated along the Dubai Canal in the heart of the financial district, close to Downtown Dubai and major business hubs."
      },
      {
        "icon": "dashicons-star-filled",
        "text": "Strong Capital Growth Potential"
      },
      {
        "icon": "dashicons-star-filled",
        "text": "Business Bay continues to see high demand and price growth, driven by its central location and ongoing development."
      },
      {
        "icon": "dashicons-star-filled",
        "text": "High Rental Demand"
      },
      {
        "icon": "dashicons-star-filled",
        "text": "Attracts professionals, corporate tenants, and short-term visitors due to its location and luxury offering."
      },
      {
        "icon": "dashicons-star-filled",
        "text": "Branded Luxury Development"
      },
      {
        "icon": "dashicons-star-filled",
        "text": "Designed in collaboration with de GRISOGONO, enhancing long-term desirability and resale value."
      }
    ],
    "highlights": [
      {
        "icon": "dashicons-marker",
        "text": "Luxury waterfront development in Business Bay"
      },
      {
        "icon": "dashicons-marker",
        "text": "Branded residences inspired by de GRISOGONO"
      },
      {
        "icon": "dashicons-marker",
        "text": "Prime position directly along the Dubai Canal"
      },
      {
        "icon": "dashicons-marker",
        "text": "Architecturally striking twin-tower design"
      },
      {
        "icon": "dashicons-marker",
        "text": "High-end interiors inspired by the blue topaz gemstone"
      },
      {
        "icon": "dashicons-marker",
        "text": "Developed by leading luxury developer DAMAC"
      }
    ],
    "amenities": [
      {
        "icon": "dashicons-yes",
        "text": "Wellness & Leisure: Infinity lap pool (“Stars Lake”) with illuminated features"
      },
      {
        "icon": "dashicons-yes",
        "text": "Wellness & Leisure: Resort-style swimming pools and relaxation areas"
      },
      {
        "icon": "dashicons-yes",
        "text": "Wellness & Leisure: Wellness and spa-inspired spaces"
      },
      {
        "icon": "dashicons-yes",
        "text": "Lifestyle & Social: Jewellery cafe and luxury social spaces"
      },
      {
        "icon": "dashicons-yes",
        "text": "Lifestyle & Social: Elite Stars Club for networking and entertainment"
      },
      {
        "icon": "dashicons-yes",
        "text": "Lifestyle & Social: High-end lounges and leisure areas"
      },
      {
        "icon": "dashicons-yes",
        "text": "Work & Convenience: Concierge and valet services"
      },
      {
        "icon": "dashicons-yes",
        "text": "Work & Convenience: Luxury lobby with designer interiors"
      },
      {
        "icon": "dashicons-yes",
        "text": "Work & Convenience: Retail and lifestyle facilities within the development"
      }
    ],
    "location_highlights": [
      {
        "icon": "dashicons-location",
        "text": "Direct access to Dubai Canal waterfront"
      },
      {
        "icon": "dashicons-location",
        "text": "Minutes from Downtown Dubai & Burj Khalifa"
      },
      {
        "icon": "dashicons-location",
        "text": "Close to Dubai Mall and DIFC"
      },
      {
        "icon": "dashicons-location",
        "text": "Surrounded by luxury hotels, offices, and restaurants"
      }
    ]
  },
  {
    "name": "Binghatti Flare",
    "slug": "binghatti-flare",
    "location": "Dubai",
    "city": "Jumeirah Village Triangle (JVT)",
    "status": "Selling Fast",
    "price": "£259,000",
    "bedrooms": "Studio - 3",
    "completion": "Q4 2027",
    "yield": "8%",
    "deposit": "20%",
    "tenure": "Freehold",
    "summary": "Binghatti Flare is a landmark residential development in Jumeirah Village Triangle (JVT), Dubai, offering design-led apartments within an iconic twin-tower project. Combining striking architecture with strong rental demand, it presents a high-growth investment opportunity in one of Dubai’s emerging residential hubs.",
    "overview": "Binghatti Flare is a bold Dubai property investment opportunity, redefining modern urban living through architecture that blends light, movement, and form. Designed as a striking twin-tower development, Flare rises as a sculptural landmark, setting a new benchmark for contemporary residential design.\n\nComprising over 1,300 residential units across two towers, the development offers a wide range of apartments from studios to four-bedroom residences, catering to both investors and end-users. Integrated retail and lifestyle spaces further enhance the appeal, creating a self-contained urban environment.\n\nLocated in Jumeirah Village Triangle (JVT), a fast-growing residential district, Flare benefits from strong connectivity to Dubai’s key destinations while offering a more community-focused living environment—supporting both tenant demand and long-term capital appreciation.",
    "photos": [
      "https://www.vidiancapital.com/objects/uploads/6c5fa7ac-be7c-47ba-b69a-949a9caf592f.png",
      "https://www.vidiancapital.com/objects/uploads/5b58b931-b472-4ee4-b097-32c6fdf6727f.png",
      "https://www.vidiancapital.com/objects/uploads/a9f8db91-f08c-4f5e-85ef-2fcd4b8ceeb5.png",
      "https://www.vidiancapital.com/objects/uploads/badee72e-6f4a-407c-a1b8-59c380f0cadb.png",
      "https://www.vidiancapital.com/objects/uploads/5bb8f8a5-3044-4bb1-8959-2f78c510d012.png",
      "https://www.vidiancapital.com/objects/uploads/fe5712e0-7c23-40a5-8b87-d822dcc79283.png",
      "https://www.vidiancapital.com/objects/uploads/4e531d25-94ce-4ae9-8a21-44e25af9b9bd.png",
      "https://www.vidiancapital.com/objects/uploads/fedae76b-f20b-4907-abf5-deb4b891b18a.png"
    ],
    "stats": [
      {
        "icon": "dashicons-money-alt",
        "label": "Prices From",
        "value": "£259,000"
      },
      {
        "icon": "dashicons-chart-bar",
        "label": "Expected Yields",
        "value": "8%"
      },
      {
        "icon": "dashicons-calendar-alt",
        "label": "Completion",
        "value": "Q4 2027"
      },
      {
        "icon": "dashicons-admin-home",
        "label": "Bedrooms",
        "value": "Studio - 3"
      },
      {
        "icon": "dashicons-vault",
        "label": "Deposit",
        "value": "20%"
      },
      {
        "icon": "dashicons-media-document",
        "label": "Tenure",
        "value": "Freehold"
      }
    ],
    "why": [
      {
        "icon": "dashicons-star-filled",
        "text": "Prime JVT Location"
      },
      {
        "icon": "dashicons-star-filled",
        "text": "Situated in a well-connected and rapidly developing area, offering access to key business and lifestyle destinations."
      },
      {
        "icon": "dashicons-star-filled",
        "text": "Strong Capital Growth Potential"
      },
      {
        "icon": "dashicons-star-filled",
        "text": "Dubai’s residential market continues to expand, with emerging communities like JVT seeing increasing demand and price growth."
      },
      {
        "icon": "dashicons-star-filled",
        "text": "High Rental Demand"
      },
      {
        "icon": "dashicons-star-filled",
        "text": "Appeals to professionals, families, and long-term tenants seeking modern, well-connected living."
      },
      {
        "icon": "dashicons-star-filled",
        "text": "Iconic Design-Led Development"
      },
      {
        "icon": "dashicons-star-filled",
        "text": "Striking twin-tower architecture enhances desirability, brand recognition, and long-term value."
      }
    ],
    "highlights": [
      {
        "icon": "dashicons-marker",
        "text": "Landmark twin-tower residential development"
      },
      {
        "icon": "dashicons-marker",
        "text": "Over 1,378 apartments across two buildings"
      },
      {
        "icon": "dashicons-marker",
        "text": "Mix of studio to 4-bedroom residences"
      },
      {
        "icon": "dashicons-marker",
        "text": "Integrated retail and lifestyle spaces"
      },
      {
        "icon": "dashicons-marker",
        "text": "Contemporary architecture inspired by light and movement"
      },
      {
        "icon": "dashicons-marker",
        "text": "Developed by leading UAE developer Binghatti"
      }
    ],
    "amenities": [
      {
        "icon": "dashicons-yes",
        "text": "Wellness & Leisure: Resort-style swimming pool and pool deck"
      },
      {
        "icon": "dashicons-yes",
        "text": "Wellness & Leisure: State of the art gym and fitness facilities"
      },
      {
        "icon": "dashicons-yes",
        "text": "Wellness & Leisure: Running track and wellness spaces"
      },
      {
        "icon": "dashicons-yes",
        "text": "Lifestyle & Social: Artificial beach and landscaped recreational areas"
      },
      {
        "icon": "dashicons-yes",
        "text": "Lifestyle & Social: Skyline views and social gathering spaces"
      },
      {
        "icon": "dashicons-yes",
        "text": "Lifestyle & Social: Children’s wet and dry play areas"
      },
      {
        "icon": "dashicons-yes",
        "text": "Work & Convenience: Luxury lobby and concierge-style services"
      },
      {
        "icon": "dashicons-yes",
        "text": "Work & Convenience: On-site retail and shopping outlets"
      },
      {
        "icon": "dashicons-yes",
        "text": "Work & Convenience: Secure parking and 24/7 security"
      }
    ],
    "location_highlights": [
      {
        "icon": "dashicons-location",
        "text": "Located in Jumeirah Village Triangle (JVT), a growing residential community with strong rental demand"
      },
      {
        "icon": "dashicons-location",
        "text": "Excellent connectivity via Sheikh Mohammed Bin Zayed Road"
      },
      {
        "icon": "dashicons-location",
        "text": "10 minutes to Dubai Marina, JBR, and Dubai Harbour"
      },
      {
        "icon": "dashicons-location",
        "text": "12 minutes to Palm Jumeirah and beachfront destinations"
      },
      {
        "icon": "dashicons-location",
        "text": "15 minutes to Expo City Dubai and major employment hubs"
      },
      {
        "icon": "dashicons-location",
        "text": "22 minutes to Al Maktoum International Airport"
      }
    ]
  },
  {
    "name": "Arisha Terraces",
    "slug": "arisha-terraces",
    "location": "Dubai",
    "city": "Dubai Studio City",
    "status": "Available",
    "price": "£142,134",
    "bedrooms": "Studio - 3",
    "completion": "Q3 2027",
    "yield": "7-9%",
    "deposit": "20%",
    "tenure": "Freehold",
    "summary": "Arisha Terraces is a premium low-rise residential development in Dubai Studio City, offering resort-style apartments designed around a central courtyard oasis. Combining strong rental demand with lifestyle-led living, it presents a compelling opportunity for both investors and end-users.",
    "overview": "Arisha Terraces is a boutique Dubai property investment opportunity, inspired by the concept of an Arabian pergola—creating a shaded, tranquil living environment centred around community and nature. The development consists of four low-rise buildings, each eight storeys high, arranged around a landscaped courtyard to deliver a peaceful, resort-style atmosphere.\n\nLocated in Dubai Studio City, one of the city’s fastest-growing districts, the development benefits from strong connectivity and proximity to key lifestyle destinations, schools, and employment hubs. Studio City is rapidly emerging as a prime investment location, driven by its role as Dubai’s media and creative hub and its expected growth over the coming years.\n\nWith over 64,000 sq. ft of amenities (almost 20% of the project area) and a wide range of apartment layouts, Arisha Terraces offers a unique combination of lifestyle, flexibility, and long-term investment potential.",
    "photos": [
      "https://www.vidiancapital.com/objects/uploads/c84549db-1d9d-4735-a644-1a4813c83b2c.png",
      "https://www.vidiancapital.com/objects/uploads/a1dbb682-e29b-4b93-8e5e-864d62fffe63.png",
      "https://www.vidiancapital.com/objects/uploads/4eeafcf2-8fc4-4059-a2a7-821b86ab85ff.png",
      "https://www.vidiancapital.com/objects/uploads/6ed9f116-df78-4dba-b359-10f9bb70dedc.png",
      "https://www.vidiancapital.com/objects/uploads/06d14c10-1a0a-4c5a-ab1f-69467f9aa9c1.png",
      "https://www.vidiancapital.com/objects/uploads/66f2736d-057b-4a06-8825-7397cf69385b.png"
    ],
    "stats": [
      {
        "icon": "dashicons-money-alt",
        "label": "Prices From",
        "value": "£142,134"
      },
      {
        "icon": "dashicons-chart-bar",
        "label": "Expected Yields",
        "value": "7-9%"
      },
      {
        "icon": "dashicons-calendar-alt",
        "label": "Completion",
        "value": "Q3 2027"
      },
      {
        "icon": "dashicons-admin-home",
        "label": "Bedrooms",
        "value": "Studio - 3"
      },
      {
        "icon": "dashicons-vault",
        "label": "Deposit",
        "value": "20%"
      },
      {
        "icon": "dashicons-media-document",
        "label": "Tenure",
        "value": "Freehold"
      }
    ],
    "why": [
      {
        "icon": "dashicons-star-filled",
        "text": "Prime Studio City Location"
      },
      {
        "icon": "dashicons-star-filled",
        "text": "Situated in one of Dubai’s fastest-growing residential districts, close to schools, retail, and key transport routes."
      },
      {
        "icon": "dashicons-star-filled",
        "text": "Strong Growth Potential"
      },
      {
        "icon": "dashicons-star-filled",
        "text": "Studio City is expected to be fully developed in the coming years, driving capital appreciation and demand."
      },
      {
        "icon": "dashicons-star-filled",
        "text": "High Rental Demand"
      },
      {
        "icon": "dashicons-star-filled",
        "text": "Appeals to professionals, creatives, and families seeking a quieter, community-focused lifestyle."
      },
      {
        "icon": "dashicons-star-filled",
        "text": "Lifestyle-Led Development"
      },
      {
        "icon": "dashicons-star-filled",
        "text": "Resort-style living with extensive amenities designed to maximise tenant appeal and retention."
      }
    ],
    "highlights": [
      {
        "icon": "dashicons-marker",
        "text": "Boutique low-rise development with 4 buildings (8 storeys each)"
      },
      {
        "icon": "dashicons-marker",
        "text": "419 apartments with 122 unique layouts"
      },
      {
        "icon": "dashicons-marker",
        "text": "Resort-style design centred around a landscaped courtyard oasis"
      },
      {
        "icon": "dashicons-marker",
        "text": "Over 64,000 sq. ft of amenities (approx. 20% of project area)"
      },
      {
        "icon": "dashicons-marker",
        "text": "Every apartment includes a balcony or terrace"
      },
      {
        "icon": "dashicons-marker",
        "text": "Developed by QUBE, with a strong track record in UAE real estate"
      }
    ],
    "amenities": [
      {
        "icon": "dashicons-yes",
        "text": "Wellness & Leisure: Swimming pool and kids’ pool"
      },
      {
        "icon": "dashicons-yes",
        "text": "Wellness & Leisure: Fully equipped gym and outdoor fitness area"
      },
      {
        "icon": "dashicons-yes",
        "text": "Wellness & Leisure: Yoga studio, sauna and steam room"
      },
      {
        "icon": "dashicons-yes",
        "text": "Wellness & Leisure: Padel court and wellness spaces"
      },
      {
        "icon": "dashicons-yes",
        "text": "Lifestyle & Social: Cinema room and community lounge"
      },
      {
        "icon": "dashicons-yes",
        "text": "Lifestyle & Social: Library and shared kitchen"
      },
      {
        "icon": "dashicons-yes",
        "text": "Lifestyle & Social: BBQ areas and bonfire zones"
      },
      {
        "icon": "dashicons-yes",
        "text": "Lifestyle & Social: Landscaped courtyards and social spaces"
      },
      {
        "icon": "dashicons-yes",
        "text": "Work & Convenience: Co-working spaces"
      },
      {
        "icon": "dashicons-yes",
        "text": "Work & Convenience: Secure underground parking and bicycle storage"
      },
      {
        "icon": "dashicons-yes",
        "text": "Work & Convenience: Smart home systems and sustainable features"
      },
      {
        "icon": "dashicons-yes",
        "text": "Work & Convenience: On-site retail and daily convenience offerings"
      }
    ],
    "location_highlights": [
      {
        "icon": "dashicons-location",
        "text": "4 minutes to GEMS Metropole School"
      },
      {
        "icon": "dashicons-location",
        "text": "5 minutes to Waitrose Supermarket"
      },
      {
        "icon": "dashicons-location",
        "text": "9 minutes to Dubai Miracle Garden & Butterfly Garden"
      },
      {
        "icon": "dashicons-location",
        "text": "10 minutes to Dubai Autodrome"
      },
      {
        "icon": "dashicons-location",
        "text": "11 minutes to Mediclinic Parkview Hospital"
      },
      {
        "icon": "dashicons-location",
        "text": "20 minutes to Al Maktoum International Airport"
      }
    ]
  }
]
JSON;
		$developments = json_decode( $json, true );
		if ( ! is_array( $developments ) ) { return; }
		foreach ( $developments as $development ) {
			self::create_or_update_development( $development );
		}
		update_option( 'vp_default_developments_seeded', VP_VERSION );
	}

	private static function create_or_update_development( $data ) {
		$slug = sanitize_title( $data['slug'] ?? '' );
		if ( ! $slug ) { return; }
		$existing = get_page_by_path( $slug, OBJECT, 'vp_property' );
		$post_data = array(
			'post_type'   => 'vp_property',
			'post_status' => 'publish',
			'post_title'  => sanitize_text_field( $data['name'] ?? '' ),
			'post_name'   => $slug,
		);
		$post_id = $existing ? $existing->ID : wp_insert_post( $post_data );
		if ( is_wp_error( $post_id ) || ! $post_id ) { return; }

		$terms = array_filter( array( $data['location'] ?? '', $data['city'] ?? '' ) );
		if ( ! empty( $terms ) ) { wp_set_object_terms( $post_id, $terms, 'vp_property_category', false ); }

		$location_label = trim( ( $data['location'] ?? '' ) . ' - ' . ( $data['city'] ?? '' ), ' -' );
		update_post_meta( $post_id, '_vp_location', sanitize_text_field( $location_label ) );
		update_post_meta( $post_id, '_vp_price', sanitize_text_field( $data['price'] ?? '' ) );
		update_post_meta( $post_id, '_vp_price_label', 'From' );
		update_post_meta( $post_id, '_vp_card_button_text', 'View Development' );
		update_post_meta( $post_id, '_vp_card_button_link', get_permalink( $post_id ) );
		update_post_meta( $post_id, '_vp_cta_button_text', 'Book Your Strategy Call' );
		update_post_meta( $post_id, '_vp_cta_button_link', 'https://iqbalhussain.aiwebdesignz.com/consultation' );
		update_post_meta( $post_id, '_vp_summary', wp_kses_post( $data['summary'] ?? '' ) );
		update_post_meta( $post_id, '_vp_overview', wp_kses_post( $data['overview'] ?? '' ) );
		update_post_meta( $post_id, '_vp_summary_label', 'Summary' );
		update_post_meta( $post_id, '_vp_overview_label', 'Overview' );
		update_post_meta( $post_id, '_vp_dev_highlights_label', 'Development Highlights' );
		update_post_meta( $post_id, '_vp_amenities_label', 'Amenities' );
		update_post_meta( $post_id, '_vp_location_highlights_label', 'Location Highlights' );
		update_post_meta( $post_id, '_vp_stats', self::clean_rows( $data['stats'] ?? array() ) );
		update_post_meta( $post_id, '_vp_why_invest_title', 'Why Invest In ' . sanitize_text_field( $data['name'] ?? '' ) . '?' );
		update_post_meta( $post_id, '_vp_why_invest_items', self::clean_rows( $data['why'] ?? array() ) );
		update_post_meta( $post_id, '_vp_dev_highlights', self::clean_rows( $data['highlights'] ?? array() ) );
		update_post_meta( $post_id, '_vp_amenities', self::clean_rows( $data['amenities'] ?? array() ) );
		update_post_meta( $post_id, '_vp_location_highlights', self::clean_rows( $data['location_highlights'] ?? array() ) );
		$photos = array_map( 'esc_url_raw', (array) ( $data['photos'] ?? array() ) );
		update_post_meta( $post_id, '_vp_remote_photos', $photos );
		if ( empty( get_post_meta( $post_id, '_thumbnail_id', true ) ) && ! empty( $photos[0] ) ) {
			update_post_meta( $post_id, '_vp_feature_image_url', $photos[0] );
		}
	}

	private static function clean_rows( $rows ) {
		$clean = array();
		foreach ( (array) $rows as $row ) {
			$clean_row = array();
			foreach ( (array) $row as $key => $value ) {
				$clean_row[ sanitize_key( $key ) ] = sanitize_text_field( $value );
			}
			$clean[] = $clean_row;
		}
		return $clean;
	}
}
