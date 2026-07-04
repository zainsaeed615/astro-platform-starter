export const sleepyHollowHours = [
  { date: 'Saturday, September 19', hours: '11am - 5pm' },
  { date: 'Sunday, September 20', hours: '11am - 5pm' },
  { date: 'Saturday, September 26', hours: '11am - 5pm' },
  { date: 'Sunday, September 27', hours: '11am - 5pm' },
  { date: 'Saturday, October 3', hours: '11am - 5pm' },
  { date: 'Sunday, October 4', hours: '11am - 5pm' },
  { date: 'Saturday, October 10', hours: '11am - 5pm' },
  { date: 'Sunday, October 11', hours: '11am - 5pm' },
  { date: 'Saturday, October 17', hours: '11am - 5pm' },
  { date: 'Sunday, October 18', hours: '11am - 5pm' },
  { date: 'Saturday, October 24', hours: '11am - 5pm' },
  { date: 'Sunday, October 25', hours: '11am - 5pm' },
  { date: 'Saturday, October 31', hours: '10am - 5pm' },
];

export const sleepyHollowTickets = {
  notes: [
    'Children 2 and under are free. 99 & over are free.',
    'Please note that adults must be accompanied by a child to enter Ichabod Payne\'s Sleepy Hollow.',
    'All tickets are good for any open day of the current season.',
    'Face painting, concessions, and Greasy Gulch Gem Mining are not part of the ticket prices. These attractions are available for an additional fee.',
    'For groups of 15 or more, please inquire for discounted rates.',
  ],
  tickets: [
    {
      id: 'regular',
      name: 'Regular Admission',
      price: '$30.00',
      per: 'per person',
      age: '3–98 years old',
      description:
        'Valid for any single open day this season at Ichabod Payne\'s Sleepy Hollow. This ticket is not timed, and you\'re welcome to enjoy the attractions for the full duration of operating hours.',
    },
    {
      id: 'family-pack',
      name: 'Family 4 Pack of Single Day Tickets',
      price: '$100.00',
      age: '3–98 years old',
      description:
        'Valid for any single open day this season at Ichabod Payne\'s Sleepy Hollow. This ticket is not timed, and you\'re welcome to enjoy the attractions for the full duration of operating hours.',
    },
    {
      id: 'season-pass',
      name: 'Season Pass',
      price: '$75.00',
      per: 'per person',
      age: '3–98 years old',
      description:
        'Use this pass on any open day this season at Ichabod Payne\'s Sleepy Hollow, as many times as you like. No timed entry—stay and explore for the full operating hours.',
    },
    {
      id: 'season-4-pack',
      name: '4 Pack Season Passes',
      price: '$200.00',
      age: '3–98 years old',
      description:
        'Use these passes on any open day this season at Ichabod Payne\'s Sleepy Hollow, as many times as you like. No timed entry—stay and explore for the full operating hours.',
    },
    {
      id: 'parking',
      name: 'Parking',
      price: '$10',
      badge: 'CASH ONLY',
      description: 'Parking is cash only. There is NO ATM onsite.',
    },
  ],
  comboTickets: [
    {
      id: 'combo-pass',
      name: 'Combo Pass',
      price: '$65.00',
      per: 'per person',
      age: '12 years of age & up',
      description:
        'Good for one visit this season to Ichabod Payne\'s Sleepy Hollow and one visit to Payne\'s Labyrinth. Visits may be used on different days. You must be 12 years of age to enter Payne\'s Labyrinth and anyone under 15 must be accompanied by a guardian. No refunds if anyone decides not to finish the haunt. If you are under 18, it is strongly advised that you or your parent call ahead to verify if a signed waiver is necessary for a dropoff. You can contact us at 903-503-5181.',
    },
    {
      id: 'ultimate-season',
      name: 'Ultimate Season Pass',
      price: '$175.00',
      per: 'per person',
      age: '12 years of age & up',
      description:
        'Good for unlimited visits this season to Ichabod Payne\'s Sleepy Hollow and Payne\'s Labyrinth. Also enjoy $5 parking (CASH ONLY). Please show your lanyard badge to the parking attendant. You must be 12 years of age to enter Payne\'s Labyrinth and anyone under 15 must be accompanied by a guardian.',
    },
    {
      id: 'fast-pass',
      name: 'Fast Pass',
      price: '$15',
      warning:
        'Please DO NOT PURCHASE a fast pass if you are ONLY attending Ichabod Payne\'s Sleepy Hollow. This add-on DOES NOT APPLY to these attractions.',
      description:
        'Skip the line at all our Payne\'s Labyrinth attractions! Fast passes may only be used once at The Barn due to the timed nature of the attraction. Fast passes are for single day use ONLY and may be used ONLY at Payne\'s Labyrinth.',
    },
  ],
};

export const sleepyHollowAttractions = [
  {
    name: 'Maze of Shadows',
    tagline: 'Are you ready for the ultimate adventure?',
    description:
      'Grab your fedoras and lace up your boots, young explorers! The Maze of Shadows is officially open for the season, and it\'s looking for its next brave expedition crew. Don\'t worry, parents—there are no jump scares or monsters here! Instead, your little archaeologists will decipher ancient hieroglyphics, navigate secret passageways, and dodge obstacles on a quest to find the legendary treasure.',
    icon: 'compass',
  },
  {
    name: 'Raiders of the Lost Snacks',
    tagline: 'SNAKES? NO. SNACKS? YES.',
    description:
      'Every little explorer needs a pit stop. Raiders of the Lost Snacks is your go-to trading post for quick bites, sweet treats, and refreshing drinks. Water and popcorn are always free–just ask! Refuel your energy, show off your goodies, and grab the snacks you need to keep the Halloween fun going!',
    icon: 'utensils',
  },
  {
    name: 'Cotton Candy Cauldron',
    tagline: 'A sweet, spooky treat spun right before your eyes!',
    description:
      'Bubble, bubble, toil, and trouble... something deliciously sweet is brewing! Follow your nose to our magical, witchy treat station where the only spell we\'re casting is a sugar rush. Watch in awe as our resident wizards spin ordinary sugar into giant, fluffy clouds of colorful cotton candy.',
    price: '$4 per serving',
    icon: 'sparkles',
  },
  {
    name: 'Hayride',
    tagline: 'Your journey begins here',
    description:
      'Before the autumn adventures begin, your journey starts with a magical, family-friendly hayride that whisks you straight from the parking lot to the gates of Sleepy Hollow.',
    icon: 'tractor',
  },
  {
    name: 'Carnival Games',
    tagline: '100% FREE to play!',
    description:
      'No Halloween adventure is complete without a trip to our bustling festival fairway! Our midway is a vibrant, kid-friendly carnival zone packed with classic challenges. The best part? Every game is 100% FREE to play! We don\'t hand out plastic trinkets, we deal in something much bigger: ultimate bragging rights.',
    icon: 'gamepad-2',
  },
  {
    name: 'Fun House',
    tagline: 'Reality just lost a dimension.',
    description:
      'Grab your glasses and step into our funhouse, a dizzying walk-through that weaponizes color and depth. Lose yourself in a psychedelic maze of neon walls and mind-bending optical illusions. Can you make it to the end when you can\'t even tell where your next step will land?',
    icon: 'eye',
  },
  {
    name: 'Greasy Gulch',
    tagline: 'Strike it rich on the wild frontier!',
    description:
      'Calling all prospectors and treasure hunters! Grab your lanterns and head deep into the heart of Vulture Valley Mining, an immersive, mine-shaft maze bursting with excitement. Navigate dark tunnels, hear the echo of old pickaxes, and follow the tracks to the secret motherlode. Once you navigate your way out of the shaft, you\'ll head straight to the rushing waters of the Greasy Gulch Sluice.',
    price: 'Maze entry is free, but mining is $10 a bag.',
    icon: 'gem',
  },
  {
    name: 'Facepainting',
    tagline: 'Hauntingly good fun',
    description:
      'Whether your little monster wants to be a creepy ghoul, a wicked witch, a magical superhero, or a friendly pumpkin, our artists will bring their imagination to life.',
    price: '$5 per person',
    icon: 'palette',
  },
];

export const sleepyHollowFaq = [
  { question: 'Can we take photos & videos inside?', answer: 'Visitors to Ichabod Payne\'s Sleepy Hollow may take video & photography if they choose.' },
  { question: 'Do you charge for parking?', answer: 'Yes. Parking is $10 CASH ONLY. There is NO ATM onsite.' },
  { question: 'Is there security?', answer: 'Private security will be on-site every night. We work hard to ensure the safety of all of our guests. We require each person to pass through our security screening before they enter the waiting line. Security screening involves weapons detector wands. Please note if you are carrying any prohibited items, your entire group will need to leave the line and place these items in your vehicle or throw them away before returning to the end of the line. If you are unsure about an item or need any special accommodations, please call us at 903-503-5181 in advance of your Arrival Time.' },
  { question: 'Can I bring my bag and stroller?', answer: 'Yes, after clearing security search.' },
  { question: 'Is there an age limit?', answer: 'No. All ages are welcome. Children 2 and under are free.' },
  { question: 'Is the Sleepy Hollow ADA accessible?', answer: 'For the most part yes. It is outdoors in a rural setting with uneven ground, but pathways are wide enough for wheelchair access. There may be certain attractions that are not as accessible. You can ask staff for assistance & information onsite if you are unsure.' },
  { question: 'Is smoking allowed?', answer: 'No, cigarettes, vapes, and illegal substances are strictly prohibited.' },
  { question: 'What can\'t we bring with us inside?', answer: 'No weapons, pets, alcoholic beverages, laser pointers, food or beverage, cigarettes, lighters, incendiary devices, fireworks, drones, or illicit or illegal substances.' },
  { question: 'Can I or my children wear a costume?', answer: 'Yes, keeping in mind the following rules.\n\nGuests 14+: No masks. No props. No prosthetics. No special effects makeup that conceals your identity. Your costume may not provide a hindrance to yourself or other guests in the attractions. Due to inclusion of minors, costumes must be reasonably modest.\n\nGuests 13 and under: may wear masks. Children may have props that are not dangerous to others. Closed toed shoes recommended.' },
  { question: 'Do you accept credit cards?', answer: 'Yes. We only accept (and you must pay) cash at parking.' },
  { question: 'Do you offer discounts?', answer: 'Yes, groups of 15 or more get a discount.' },
  { question: 'May we bring a picnic?', answer: 'No. Due to insurance regulations no outside food or beverage may be brought into the Sleepy Hollow. However, we do provide free water & popcorn.' },
  { question: 'If I buy my ticket online do I have to print it out?', answer: 'Online tickets will be emailed to you. You may print it out or show us on your phone.' },
  { question: 'Can I leave my child unattended?', answer: 'No. All children must be accompanied at all times. In addition, all adults MUST BE accompanied by a child to gain entry to Sleepy Hollow.' },
  { question: 'Can I attend as an adult without a child?', answer: 'No. All adults MUST be accompanied by a child to gain entry into Sleepy Hollow. If you or your loved one needs special accommodations, please contact us at 903-503-5181.' },
  { question: 'Can I leave & come back?', answer: 'Yes, you have in & out privileges to come and go throughout the day. Please make sure you keep your wristband on to guarantee re-entry.' },
  { question: 'Do you rent electric carts or scooters?', answer: 'No we do not rent carts or scooters. You are welcome to bring a mobility scooter but no other vehicles are allowed.' },
  { question: 'Do your attractions have a height requirement?', answer: 'No.' },
  { question: 'What attractions are included in the admission price?', answer: 'It\'s easier to say what is not included: lazer tag, take home pumpkin, face painting, concessions.' },
  { question: 'What age is most appropriate for Ichabod Payne\'s Sleepy Hollow?', answer: 'Children ages 3 and up will enjoy an immersive experience going through different themed attractions. This lends itself to the imaginative child.' },
  { question: 'Do adults need a ticket?', answer: 'Yes. Everyone over the age of 2 must have a ticket for entry.' },
  { question: 'Can I also go to Payne\'s Labyrinth with the same ticket?', answer: 'No. Payne\'s Labyrinth requires a separate ticket. If you would like to visit both worlds, you can always purchase a Combo Pass Ticket (one day pass) or the Ultimate Season Pass which grants access during all open hours to both worlds & their included attractions.' },
];
