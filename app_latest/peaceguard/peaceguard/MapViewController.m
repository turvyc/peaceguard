//
//  MapViewController.m
//  peaceguard
//
//  Created by JonasYao on 2013-03-19.
//  Copyright (c) 2013 Ashley Lesperance. All rights reserved.
//

#import "MapViewController.h"
#import <math.h>
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
    //View setup
    self.postPatrolDisplay.hidden = YES;
    self.reportButton.enabled = YES;
    self.startStopButton.enabled = YES;
    self.patrolControlButton.alpha = 0.60;
    // Do any additional setup after loading the view.
    //Location setup
    locationManager = [[CLLocationManager alloc] init];
    geocoder = [[CLGeocoder alloc] init];
    self.location_array = [[NSMutableArray alloc] init];
    locationManager.delegate = self; // Tells the location manager to send updates to this object
    locationManager.desiredAccuracy = kCLLocationAccuracyBest;
    [self.mapView setUserTrackingMode:MKUserTrackingModeFollowWithHeading animated:NO];
    //Timer setup
    self.timer = [[Timer alloc] init];
    //User currently not patrolling
    self.patrolling = NO;
    //Prevent user from moving map
    self.mapView.userInteractionEnabled = NO;
    //Get the username for future use
    NSUserDefaults *defaults = [NSUserDefaults standardUserDefaults];
    NSString *username = [defaults objectForKey:@"username"];
    self.username = username;
}

- (void)viewDidAppear:(BOOL)animated {
}


- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

- (void)dealloc
{
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
        //Prevent phone from turning off automatically
        [UIApplication sharedApplication].idleTimerDisabled = YES;
        //Hide back button
        [self.navigationItem setHidesBackButton:YES animated:YES];
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
        //_start = YES;
        //_cache_number = 1;
        [locationManager startUpdatingLocation];
        //self.connectionManager = [[ConnectionDataController alloc] init];
        //NSDate *currDate = [NSDate date];
        //NSDateFormatter *dateFormatter = [[NSDateFormatter alloc]init];
        //[dateFormatter setDateFormat:@"dd.MM.YY HH:mm:ss"];
        //NSString *dateString = [dateFormatter stringFromDate:currDate];
        //self.start_time = dateString;
    }
    //Stopping a patrol
    else if (self.patrolling){
        //Allow the phone to be disabled automatically
        [UIApplication sharedApplication].idleTimerDisabled = NO;
        
        //End the patrol
        self.patrolling = NO;
        
        //Stop updating breadcrumbs
        [locationManager stopUpdatingLocation];
        
        //Reset the button text
        self.patrolControlLabel.text = @"Start Patrol";
        
        //Stop clock
        [self.clock invalidate];
        
        //From locationViewController
        NSLog(@"stop Patrol");
        NSLog(@"The patrol ID is %i",self.patrolID);
        
        //Stop all the location and timer tool, also record the data
        [locationManager stopUpdatingLocation];
        [self.timer stopTimer];

        
        //After stop patrolling, application sends the duration, distance and patrol ID to the server
        self.connectionManager = [[ConnectionDataController alloc] init];
        [self.connectionManager endAndSendPatrolID:self.patrolID duration:(NSInteger)[self.timer timeElapsedInSeconds] route:self.crumbs.getCrumbPathJSON distance:self.crumbs.getCrumbPathDistance email:self.username];
        //Badges are handled here if necessary
        //NSDictionary *badgesDictionary = [self.connectionManager getBadge:self.username andTimePeriod:@"allTime"];
        //NSString *b_id = [[badgesDictionary objectForKey:@"badges"] objectForKey:@"b_id"];
        //NSString *name = [[badgesDictionary objectForKey:@"badges"] objectForKey:@"name"];
        
        //Dismiss the view and show the user statistics
        self.startStopButton.enabled = NO;
        self.reportButton.enabled = NO;
        self.postPatrolDisplay.hidden = NO;
        
        
        //************Badges earned*********************
//        if (new bagdes){
//            self.postPatrolMessage.text = @"New bagdge(s) earned";
//        }
//        else if(no new badges){
//            self.postPatrolMessage.text = @"No new badge earned";
//        }

    }
        

}

-(void) updateLabels{
    //NSString *timerString = [NSString stringWithFormat:@"%f",[self.timer timeElapsedInSeconds]];
    self.displayedTime++;
    NSString *timerString = [NSString stringWithFormat:@"%i Minutes %i Seconds",(self.displayedTime)/60, (int)(fmod(((double)self.displayedTime), 60))];
    //NSLog(@"Timer string: %@", timerString);
    self.durationDisplay.text = timerString;
    self.distanceDisplay.text = [NSString stringWithFormat:@"%.01f Meters",self.crumbs.getCrumbPathDistance] ;
}
- (IBAction)makeReport:(id)sender {
    [self performSegueWithIdentifier:@"mapToReport" sender:self];
}
- (IBAction)postPatrolButton:(id)sender {
    
    self.startStopButton.enabled = YES;
    self.reportButton.enabled = YES;
    self.postPatrolDisplay.hidden = YES;
    
    [self.navigationController popViewControllerAnimated:YES];
}
@end
