//
//  ReportViewController.h
//  peaceguard
//
//  Created by JonasYao on 2013-02-15.
//  Copyright (c) 2013 Ashley Lesperance. All rights reserved.
//

#import <UIKit/UIKit.h>
#import <MobileCoreServices/MobileCoreServices.h>

@interface ReportViewController : UIViewController <UITextFieldDelegate, UIImagePickerControllerDelegate, UINavigationControllerDelegate>
@property (weak, nonatomic) IBOutlet UIButton *Image;
//open the camera and take the picture
- (IBAction)ImageTaker:(id)sender;

@property (weak, nonatomic) IBOutlet UIImageView *imageView;
@property(strong, nonatomic) ReportViewController *reportController;
@property (weak, nonatomic) IBOutlet UIButton *submit;

//PickerView
@property (strong, nonatomic) IBOutlet UIPickerView *thePickerView;
//used to block other fields when using pickerview
@property (strong, nonatomic) IBOutlet UIView *pickerViewBlocker;
//-incident/severity array
@property (strong, nonatomic) NSArray *incidentSelection;
@property (strong, nonatomic) NSArray *severitySelection;
@property (strong, nonatomic) IBOutlet UILabel *incidentLabel;
@property (strong, nonatomic) IBOutlet UILabel *severityLabel;
//-Data from pickerview
@property (strong, nonatomic) NSString *incidentData;   //change to be consistent with server - same as severity
@property (strong, nonatomic) NSString *severityData;

//temp variable for overview
@property (strong, nonatomic) NSString *incidentOverview;
@property (strong, nonatomic) NSString *severityOverview;
@property (strong, nonatomic) NSString *descriptionOverview;
@property (strong, nonatomic) UIImage *imageOverview;

//-open/close pickerview for incident type/severity
- (IBAction)incidentButtonPressed:(id)sender;
- (IBAction)severityButtonPressed:(id)sender;
- (IBAction)doneSelection:(id)sender;

//items are held in the overview screen
@property (strong, nonatomic) IBOutlet UILabel *incidentOverviewDisplay;
@property (strong, nonatomic) IBOutlet UILabel *severityOverviewDisplay;
@property (strong, nonatomic) IBOutlet UITextField *descriptionOverviewDisplay;
@property (strong, nonatomic) IBOutlet UIImageView *imageOverviewDisplay;

- (IBAction) submitAction:(id)sender;
- (BOOL) verify: (NSString*) description;

@property (weak, nonatomic) IBOutlet UITextField *description;
//put the image in the specific place and show it to the user
- (void)imagePickerController:(UIImagePickerController *)picker didFinishPickingMediaWithInfo:(NSDictionary *)info;
@end
