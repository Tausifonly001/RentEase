let map, marker, destinationMarker;
let deliverySubscription;

function initMap() {
    const defaultLocation = { lat: 40.7128, lng: -74.0060 }; // Default to NYC if no data
    
    if (typeof google === 'undefined') {
        console.error('Google Maps API not loaded.');
        document.getElementById('map-container').innerHTML = '<div class="w-full h-full flex items-center justify-center bg-slate-100 text-slate-500 font-bold">Map unavailable (check API key)</div>';
        return;
    }

    map = new google.maps.Map(document.getElementById("map-container"), {
        zoom: 15,
        center: defaultLocation,
        disableDefaultUI: true,
        zoomControl: true,
        styles: [
            // Optional: light theme styling to match aesthetic
            {
                "featureType": "all",
                "elementType": "geometry.fill",
                "stylers": [{"weight": "2.00"}]
            },
            {
                "featureType": "all",
                "elementType": "geometry.stroke",
                "stylers": [{"color": "#9c9c9c"}]
            },
            {
                "featureType": "all",
                "elementType": "labels.text",
                "stylers": [{"visibility": "on"}]
            },
            {
                "featureType": "landscape",
                "elementType": "all",
                "stylers": [{"color": "#f2f2f2"}]
            },
            {
                "featureType": "landscape",
                "elementType": "geometry.fill",
                "stylers": [{"color": "#ffffff"}]
            },
            {
                "featureType": "landscape.man_made",
                "elementType": "geometry.fill",
                "stylers": [{"color": "#ffffff"}]
            },
            {
                "featureType": "poi",
                "elementType": "all",
                "stylers": [{"visibility": "off"}]
            },
            {
                "featureType": "road",
                "elementType": "all",
                "stylers": [{"saturation": -100}, {"lightness": 45}]
            },
            {
                "featureType": "road",
                "elementType": "geometry.fill",
                "stylers": [{"color": "#eeeeee"}]
            },
            {
                "featureType": "road",
                "elementType": "labels.text.fill",
                "stylers": [{"color": "#7b7b7b"}]
            },
            {
                "featureType": "road",
                "elementType": "labels.text.stroke",
                "stylers": [{"color": "#ffffff"}]
            },
            {
                "featureType": "road.highway",
                "elementType": "all",
                "stylers": [{"visibility": "simplified"}]
            },
            {
                "featureType": "road.arterial",
                "elementType": "labels.icon",
                "stylers": [{"visibility": "off"}]
            },
            {
                "featureType": "transit",
                "elementType": "all",
                "stylers": [{"visibility": "off"}]
            },
            {
                "featureType": "water",
                "elementType": "all",
                "stylers": [{"color": "#46bcec"}, {"visibility": "on"}]
            },
            {
                "featureType": "water",
                "elementType": "geometry.fill",
                "stylers": [{"color": "#c8d7d4"}]
            },
            {
                "featureType": "water",
                "elementType": "labels.text.fill",
                "stylers": [{"color": "#070707"}]
            },
            {
                "featureType": "water",
                "elementType": "labels.text.stroke",
                "stylers": [{"color": "#ffffff"}]
            }
        ]
    });

    marker = new google.maps.Marker({
        position: defaultLocation,
        map: map,
        icon: {
            url: 'https://cdn-icons-png.flaticon.com/512/2830/2830305.png',
            scaledSize: new google.maps.Size(40, 40)
        },
        title: "Delivery Agent"
    });

    if (window.destinationCoords && window.destinationCoords.lat) {
        destinationMarker = new google.maps.Marker({
            position: window.destinationCoords,
            map: map,
            title: "Your Location"
        });
        
        const bounds = new google.maps.LatLngBounds();
        bounds.extend(defaultLocation);
        bounds.extend(window.destinationCoords);
        map.fitBounds(bounds);
    }

    startRealtimeTracking();
}

function updateMap(lat, lng) {
    const newPos = { lat, lng };
    
    // Smooth transition
    marker.setPosition(newPos);

    if (window.destinationCoords && window.destinationCoords.lat) {
        const bounds = new google.maps.LatLngBounds();
        bounds.extend(newPos);
        bounds.extend(window.destinationCoords);
        
        // Auto adjust bounds but don't zoom in too close
        map.fitBounds(bounds);
        
        // Ensure zoom isn't too tight if they are close
        const listener = google.maps.event.addListener(map, "idle", function() { 
            if (map.getZoom() > 16) map.setZoom(16); 
            google.maps.event.removeListener(listener); 
        });
    } else {
        map.panTo(newPos);
    }
}

function startRealtimeTracking() {
    if (!window.supabaseClient || !window.activeOrderId) return;
    
    const supabase = window.supabaseClient;

    // Listen to changes
    deliverySubscription = supabase.channel('custom-filter-channel')
        .on(
            'postgres_changes',
            { event: '*', schema: 'public', table: 'delivery_logistics', filter: `order_id=eq.${window.activeOrderId}` },
            (payload) => {
                if (payload.new && payload.new.latitude && payload.new.longitude) {
                    updateMap(payload.new.latitude, payload.new.longitude);
                    document.getElementById('lastUpdatedText').innerText = 'Updated just now';
                }
            }
        )
        .subscribe((status) => {
            if (status === 'SUBSCRIBED') {
                console.log('Realtime delivery tracking active.');
            }
        });
        
    // Fetch initial location
    supabase
        .from('delivery_logistics')
        .select('latitude, longitude')
        .eq('order_id', window.activeOrderId)
        .single()
        .then(({ data, error }) => {
            if (data && data.latitude) {
                updateMap(data.latitude, data.longitude);
            }
        });
}

// Map is loaded via callback from Google Maps script tag
window.initMap = initMap;
