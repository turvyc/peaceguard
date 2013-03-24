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

@implementation MapViewController

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
	// Do any additional setup after loading the view.
    self.patrolling = NO;
    
    // Note: we are using Core Location directly to get the user location updates.
    // We could normally use MKMapView's user location update delegation but this does not work in
    // the background.  Plus we want "kCLLocationAccuracyBestForNavigation" which gives us a better accuracy.
    //
    self.locationManager = [[CLLocationManager alloc] init];
    self.locationManager.delegate = self; // Tells the location manager to send updates to this object
    
    self.locationManager.desiredAccuracy = kCLLocationAccuracyBest;
    [self.mapView setUserTrackingMode:MKUserTrackingModeFollowWithHeading animated:NO];
    
    
    
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
    self.locationManager.delegate = nil;
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
                //
                // note: iPhone 3G will locate you using the triangulation of the cell towers.
                // so you may experience spikes in location data (in small time intervals)
                // due to 3G tower triangulation.
                //
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
    
    [self.locationManager startUpdatingLocation];
    
}
@end
