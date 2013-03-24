//
//  PatrolViewController.h
//
//  Contributor(s): Ashley Lesperance, Jonas Yao
//
//  Copyright (c) 2013 Number 123 Developer's Group
//

#import <UIKit/UIKit.h>
#import <MapKit/MapKit.h>

@interface PatrolViewController : UIViewController
@property(nonatomic) NSString *username;

- (IBAction)statisticsButton:(id)sender;
- (IBAction)locationButton:(id)sender;

@property(nonatomic) NSString *segueType;

@end
