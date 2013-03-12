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

@property (weak, nonatomic) IBOutlet UIButton *startPatrol;
@property (weak, nonatomic) IBOutlet UIButton *stopPatrol;
- (IBAction)Stop:(id)sender;

- (IBAction)Start:(id)sender;
@property (weak, nonatomic) IBOutlet UITextField *Time;

@end
