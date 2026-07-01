VIDIAN PROPERTY LISTINGS — Setup Guide
========================================

1) INSTALL
   - Is poori "vidian-property-listings" folder ko zip karke
     WordPress > Plugins > Add New > Upload Plugin se install karein.
   - Plugin Activate karein. (Elementor install/active hona chahiye taake
     widgets Elementor editor me dikhein — plugin khud bina Elementor ke
     bhi properties add/list kar dega.)

2) PROPERTY ADD KARNA
   - Left menu me "Properties" > "Add New Property" pr jayein.
   - Title: Property ka naam (e.g. Waterhouse Gardens)
   - Featured Image: (right side box) — yehi image card aur detail page
     ki "feature image" banegi.
   - "Card / Hero Info" box: Location, Price, buttons ke text/link.
   - "Feature Image + Gallery" box: "Add Gallery Images" se multiple
     images add karein — yeh detail page pr scroll hone wali gallery
     thumbnails banengi.
   - "Icon Stat Boxes": Expected Yields, Completion, Bedrooms, Deposit,
     Tenure jese boxes — icon field me koi Dashicon class daal sakte hain
     (list: https://developer.wordpress.org/resource/dashicons/), e.g.
     dashicons-chart-bar, dashicons-calendar-alt, dashicons-yes,
     dashicons-location, dashicons-star-filled.
   - Summary / Overview box.
   - Development Highlights / Amenities / Location Highlights — "+ Add
     Item" se jitni chahein lines add karein, har ek ka icon bhi editable.
   - "Why Invest In..." sidebar box — title + list items.
   - Map box — sirf address/city likhein (e.g. "Manchester, UK"), map
     khud-b-khud embed ho jayega. "Open in Maps" ka link optional hai.
   - "Inquiry Notification Email" — agar iss property ki inquiries kisi
     alag email pr chahiye to yahan daalein, warna global default use
     hoga (neeche settings dekhen).

3) GLOBAL SETTINGS (Inquiry Email)
   - Properties > Settings me jayein.
   - "Default Inquiry Notification Email" — jab koi bhi property page ka
     "Request Information" form fill kare to mail isi address pr jayegi.

4) ELEMENTOR ME USE KARNA
   Elementor editor kholein aur left panel me "Vidian Property" category
   ke neeche 3 widgets milenge:

   a) "Single Property Card" -> Home page / anywhere ek single property
                                 card dikhane ke liye (Image 1 wala design).
                                 Widget me dropdown se property select karein.

   b) "Properties Grid - Multiple Listings"
                              -> Home page pr multiple cards ek grid me
      (Listing)                 dikhane ke liye. Columns, count, category
                                filter options available hain.
                                Multiple properties dikhani hon to YE widget
                                use karein. Default count -1 hai, yani all
                                published properties show hongi.

   c) "Property Full Details" -> Single property page pr poori detail
                                  (gallery, icon stats, summary, overview,
                                  highlights, amenities, why invest, map,
                                  aur inquiry form) — Image 2 wala design.
                                  "current property" select karke isko
                                  Property CPT ke Single template
                                  (Elementor Theme Builder) pr laga dein
                                  taake har property apni details khud
                                  show kare.

5) NOTE
   - Plugin ab single property URL (/properties/property-slug/) par apna
     full detail template automatically load karta hai, chahe Elementor active
     ho. Is se title-only / blank page ka masla fix hota hai.
   - Archive URL (/properties/) par bhi plugin grid fallback template load
     karta hai.
   - Sab colors/spacing "assets/css/frontend.css" file me hain — agar
     brand colors change karni hon to wahan "--vp-navy" variable update
     kar dein.
