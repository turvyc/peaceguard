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
}

- (void)viewDidAppear:(BOOL)animated {
    CLLocationCoordinate2D zoomLocation;
    NSUserDefaults *defaults = [NSUserDefaults standardUserDefaults];
    NSString *la = [defaults objectForKey:@"starLatitude"];
    NSString *lo = [defaults objectForKey:@"starLongitude"];
    double latitude = [la doubleValue];
    double longitude = [lo doubleValue];
    zoomLocation.latitude = latitude;
    zoomLocation.longitude = longitude;
    MKCoordinateRegion viewRegion = MKCoordinateRegionMakeWithDistance(zoomLocation, 0.5*METERS_PER_MILE, 0.5*METERS_PER_MILE);
    MKCoordinateRegion adjustRegion = [_mapView regionThatFits:viewRegion];
    [_mapView setRegion:adjustRegion animated:YES];
    NSString *incidentData = [defaults objectForKey:@"incidentData"];
    NSString *serverityData = [defaults objectForKey:@"serverityData"];
    if (incidentData != nil && serverityData != nil){
        MKPointAnnotation *point = [[MKPointAnnotation alloc] init];
        point.coordinate = zoomLocation;
        point.title = incidentData;
        point.subtitle = serverityData;
        [_mapView addAnnotation:point];
    }
}


- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

@end
