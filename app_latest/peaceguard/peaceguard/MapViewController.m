//
//  MapViewController.m
//  peaceguard
//
//  Created by JonasYao on 2013-03-19.
//  Copyright (c) 2013 Ashley Lesperance. All rights reserved.
//

#import "MapViewController.h"

@interface MapViewController ()

@end

@implementation MapViewController {
    CLLocationManager *locationManager;
    CLGeocoder *geocoder;
    CLPlacemark *placemark;
}

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    //Hide back button
    [self.navigationItem setHidesBackButton:YES animated:YES];
    // Do any additional setup after loading the view.
    //Allocations
    locationManager = [[CLLocationManager alloc] init];
    geocoder = [[CLGeocoder alloc] init];
    _location_array = [[NSMutableArray alloc] init];
    _timer = [[Timer alloc] init];
    locationManager = [[CLLocationManager alloc] init];
	
    //User currently not patrolling
    self.patrolling = NO;
    
    locationManager.delegate = self; // Tells the location manager to send updates to this object
    
    locationManager.desiredAccuracy = kCLLocationAccuracyBest;
    [self.mapView setUserTrackingMode:MKUserTrackingModeFollowWithHeading animated:NO];
    self.patrolControlButton.alpha = 0.60;
    
    NSUserDefaults *defaults = [NSUserDefaults standardUserDefaults];
    NSString *username = [defaults objectForKey:@"username"];
    self.username = username;
    NSLog(@"username in the location view :%@", self.username);
    //[super viewDidLoad];

    //[self.view addSubview:self.mapView];
}

- (void)viewDidAppear:(BOOL)animated {
//    CLLocationCoordinate2D zoomLocation;
//    NSUserDefaults *defaults = [NSUserDefaults standardUserDefaults];
//    NSString *la = [defaults objectForKey:@"starLatitude"];
//    NSString *lo = [defaults objectForKey:@"starLongitude"];
//    double latitude = [la doubleValue];
//    double longitude = [lo doubleValue];
//    zoomLocation.latitude = latitude;
//    zoomLocation.longitude = longitude;
//    MKCoordinateRegion viewRegion = MKCoordinateRegionMakeWithDistance(zoomLocation, 0.5*METERS_PER_MILE, 0.5*METERS_PER_MILE);
//    MKCoordinateRegion adjustRegion = [_mapView regionThatFits:viewRegion];
//    [_mapView setRegion:adjustRegion animated:YES];
//    NSString *incidentData = [defaults objectForKey:@"incidentData"];
//    NSString *serverityData = [defaults objectForKey:@"serverityData"];
//    if (incidentData != nil && serverityData != nil){
//        MKPointAnnotation *point = [[MKPointAnnotation alloc] init];
//        point.coordinate = zoomLocation;
//        point.title = incidentData;
//        point.subtitle = serverityData;
//        [_mapView addAnnotation:point];
//    }
}


- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

- (void)dealloc
{
    //NSLog(@"Points count: %i",self.crumbs.pointCount);
    //NSLog(@"Points: %@",MKStringFromMapPoint(*(self.crumbs.points)));
    locationManager.delegate = nil;
}

#pragma mark - MapKit

- (void)locationManager:(CLLocationManager *)manager
    didUpdateToLocation:(CLLocation *)newLocation
           fromLocation:(CLLocation *)oldLocation
{
    if (newLocation)
    {
        
		
		// make sure the old and new coordinates are different
        if ((oldLocation.coordinate.latitude != newLocation.coordinate.latitude) &&
            (oldLocation.coordinate.longitude != newLocation.coordinate.longitude))
        {
            if (!self.crumbs)
            {
                // This is the first time we're getting a location update, so create
                // the CrumbPath and add it to the map.
                //
                _crumbs = [[CrumbPath alloc] initWithCenterCoordinate:newLocation.coordinate];
                [self.mapView addOverlay:self.crumbs];
                
                // On the first location update only, zoom map to user location
                MKCoordinateRegion region =
                MKCoordinateRegionMakeWithDistance(newLocation.coordinate, 2000, 2000);
                [self.mapView setRegion:region animated:YES];
            }
            else
            {
                // This is a subsequent location update.
                // If the crumbs MKOverlay model object determines that the current location has moved
                // far enough from the previous location, use the returned updateRect to redraw just
                // the changed area.
                MKMapRect updateRect = [self.crumbs addCoordinate:newLocation.coordinate];
                //NSLog(@"Points: %@",MKStringFromMapPoint(*(self.crumbs.points)));
                if (!MKMapRectIsNull(updateRect))
                {
                    // There is a non null update rect.
                    // Compute the currently visible map zoom scale
                    MKZoomScale currentZoomScale = (CGFloat)(self.mapView.bounds.size.width / self.mapView.visibleMapRect.size.width);
                    // Find out the line width at this zoom scale and outset the updateRect by that amount
                    CGFloat lineWidth = MKRoadWidthAtZoomScale(currentZoomScale);
                    updateRect = MKMapRectInset(updateRect, -lineWidth, -lineWidth);
                    // Ask the overlay view to update just the changed area.
                    [self.crumbView setNeedsDisplayInMapRect:updateRect];
                }
            }
        }
    }
}

- (MKOverlayView *)mapView:(MKMapView *)mapView viewForOverlay:(id <MKOverlay>)overlay
{
    if (!self.crumbView)
    {
        _crumbView = [[CrumbPathView alloc] initWithOverlay:overlay];
    }
    return self.crumbView;
}


- (IBAction)patrolControl:(id)sender {
    //Starting a patrol
    if (!self.patrolling) {
        self.patrolling = YES;
        [locationManager startUpdatingLocation];
        self.patrolControlLabel.text = @"Stop Patrol";
        
        //From locationViewController
        NSLog(@"start Patrol");
        NSLog(@"The patrol ID is %i",self.patrolID);
        //all initialize
        self.connectionManager = [[ConnectionDataController alloc] init];
        self.patrolID = [self.connectionManager startPatrolWithEmail:self.username];
        locationManager.delegate = self;
        locationManager.desiredAccuracy = kCLLocationAccuracyBest;
        //Start keeping time and updating the label
        self.displayedTime = 0;
        [self.timer startTimer];
        NSTimer *runningTimer = [NSTimer scheduledTimerWithTimeInterval:1.0
                                                          target:self selector:@selector(updateLabels)
                                                        userInfo:Nil repeats:YES];
        self.clock = runningTimer;
        _start = YES;
        _cache_number = 1;
        [locationManager startUpdatingLocation];
        self.connectionManager = [[ConnectionDataController alloc] init];
        NSDate *currDate = [NSDate date];
        NSDateFormatter *dateFormatter = [[NSDateFormatter alloc]init];
        [dateFormatter setDateFormat:@"dd.MM.YY HH:mm:ss"];
        NSString *dateString = [dateFormatter stringFromDate:currDate];
        self.start_time = dateString;
    }
    //Stopping a patrol
    else if (self.patrolling){
        self.patrolling = NO;
        [locationManager stopUpdatingLocation];
        self.patrolControlLabel.text = @"Start Patrol";
        //Stop clock
        [self.clock invalidate];
        //From locationViewController
        NSLog(@"stop Patrol");
        NSLog(@"The patrol ID is %i",self.patrolID);
//        CLLocationDistance meters = 0;
        
        //Stop all the location and timer tool, also record the data
        [locationManager stopUpdatingLocation];
        [self.timer stopTimer];
        //NSString *timerString = [NSString stringWithFormat:@"%i",(int)[self.timer timeElapsedInSeconds]];
        //self.durationDisplay.text = timerString;
        
        //Use CLLocationDistance to count the distance of patrolling
//        _final_location = [_location_array lastObject];
//        if(_final_location == nil){
//            _final_location = _start_location;
//        }
//        if (_start_location != nil){
//            meters = [_final_location distanceFromLocation:_start_location];
//            NSString *distanceString = [NSString stringWithFormat:@"%f",meters/1000];
//            NSLog(@"The distance is %@",distanceString);
//            if(meters/1000 != 0.000000){
//                _distanceDisplay.text = distanceString;
//            }else{
//                _distanceDisplay.text = [NSString stringWithFormat:@"%f",0.000000];
//            }
//        }
        
        //After stop patrolling, application sends the duration, distance and patrol ID to the server
        self.connectionManager = [[ConnectionDataController alloc] init];
        [self.connectionManager endAndSendPatrolID:self.patrolID duration:(NSInteger)[self.timer timeElapsedInSeconds] route:self.crumbs.getCrumbPathJSON distance:self.crumbs.getCrumbPathDistance email:self.username];
        //Badges are handled here if necessary
        //NSDictionary *badgesDictionary = [self.connectionManager getBadge:self.username andTimePeriod:@"allTime"];
        //NSString *b_id = [[badgesDictionary objectForKey:@"badges"] objectForKey:@"b_id"];
        //NSString *name = [[badgesDictionary objectForKey:@"badges"] objectForKey:@"name"];
        
        //Dismiss the view and show the user statistics
        [self.navigationController popViewControllerAnimated:YES];
    }
        

}

-(void) updateLabels{
    //NSString *timerString = [NSString stringWithFormat:@"%f",[self.timer timeElapsedInSeconds]];
    self.displayedTime++;
    NSString *timerString = [NSString stringWithFormat:@"%i Seconds",self.displayedTime];
    //NSLog(@"Timer string: %@", timerString);
    self.durationDisplay.text = timerString;
    self.distanceDisplay.text = [NSString stringWithFormat:@"%.01f Meters",self.crumbs.getCrumbPathDistance] ;
}
- (IBAction)makeReport:(id)sender {
    [self performSegueWithIdentifier:@"mapToReport" sender:self];
}
@end
