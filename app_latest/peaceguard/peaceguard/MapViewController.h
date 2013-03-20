//
//  MapViewController.h
//  peaceguard
//
//  Created by JonasYao on 2013-03-19.
//  Copyright (c) 2013 Ashley Lesperance. All rights reserved.
//

#import <UIKit/UIKit.h>
#import <MapKit/MapKit.h>

#define METERS_PER_MILE 1609.344

@interface MapViewController : UIViewController

@property (weak, nonatomic) IBOutlet MKMapView *mapView;
@end
